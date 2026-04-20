<?php

namespace App\Http\Controllers;

use App\Models\AdminActivity;
use App\Models\VocabCategory;
use App\Models\VocabWord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminVocabCsvController extends Controller
{
    public function export(Request $request)
    {
        $filename = 'kosakata-' . now()->format('Ymd-His') . '.csv';

        AdminActivity::query()->create([
            'actor_id' => $request->user()?->id,
            'icon' => '⬇️',
            'description' => 'Ekspor CSV kosakata',
            'action' => 'vocab.export',
            'subject_type' => VocabWord::class,
            'properties' => [
                'filename' => $filename,
            ],
        ]);

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');

            fputcsv($out, ['indo', 'jawa', 'emoji', 'category_slug', 'category_name', 'is_published', 'status']);

            VocabWord::query()
                ->with('category:id,slug,name')
                ->orderBy('indo')
                ->chunk(500, function ($chunk) use ($out) {
                    foreach ($chunk as $w) {
                        fputcsv($out, [
                            $w->indo,
                            $w->jawa,
                            $w->emoji,
                            $w->category?->slug,
                            $w->category?->name,
                            $w->is_published ? 1 : 0,
                            $w->status,
                        ]);
                    }
                });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function import(Request $request)
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $file = $data['file'];

        $handle = fopen($file->getRealPath(), 'r');
        if ($handle === false) {
            return redirect()->route('admin.home', ['view' => 'kosakata'])->with('status', 'File tidak bisa dibaca.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return redirect()->route('admin.home', ['view' => 'kosakata'])->with('status', 'CSV kosong.');
        }

        $header = array_map(fn($h) => Str::of($h)->lower()->trim()->toString(), $header);
        $idx = array_flip($header);

        foreach (['indo', 'jawa'] as $required) {
            if (!array_key_exists($required, $idx)) {
                fclose($handle);
                return redirect()->route('admin.home', ['view' => 'kosakata'])->with('status', 'Header CSV wajib: indo, jawa.');
            }
        }

        $count = 0;
        $created = 0;
        $updated = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $count++;

            $indo = trim((string) ($row[$idx['indo']] ?? ''));
            $jawa = trim((string) ($row[$idx['jawa']] ?? ''));

            if ($indo === '' || $jawa === '') {
                continue;
            }

            $emoji = array_key_exists('emoji', $idx) ? trim((string) ($row[$idx['emoji']] ?? '')) : null;
            $emoji = $emoji !== '' ? $emoji : null;

            $categorySlug = array_key_exists('category_slug', $idx) ? trim((string) ($row[$idx['category_slug']] ?? '')) : null;
            $categorySlug = $categorySlug !== '' ? Str::slug($categorySlug) : null;

            $categoryName = array_key_exists('category_name', $idx) ? trim((string) ($row[$idx['category_name']] ?? '')) : null;
            $categoryName = $categoryName !== '' ? $categoryName : null;

            $isPublished = true;
            if (array_key_exists('is_published', $idx)) {
                $raw = trim((string) ($row[$idx['is_published']] ?? '1'));
                $isPublished = !in_array($raw, ['0', 'false', 'no'], true);
            }

            $status = $isPublished ? 'published' : 'draft';
            if (array_key_exists('status', $idx)) {
                $rawStatus = Str::of((string) ($row[$idx['status']] ?? ''))->lower()->trim()->toString();
                if (in_array($rawStatus, ['draft', 'pending', 'published', 'rejected'], true)) {
                    $status = $rawStatus;
                }
            }

            $categoryId = null;
            if ($categorySlug) {
                $category = VocabCategory::query()->firstOrCreate(
                    ['slug' => $categorySlug],
                    ['name' => $categoryName ?? Str::headline($categorySlug)]
                );
                $categoryId = $category->id;
            }

            $attributes = [
                'vocab_category_id' => $categoryId,
                'indo' => $indo,
            ];

            $values = [
                'jawa' => $jawa,
                'emoji' => $emoji,
                'is_published' => $isPublished,
                'status' => $status,
            ];

            $word = VocabWord::query()->where($attributes)->first();
            if ($word) {
                $word->fill($values);
                $word->save();
                $updated++;
            } else {
                VocabWord::query()->create($attributes + $values + [
                    'created_by' => $request->user()?->id,
                    'published_at' => $isPublished ? now() : null,
                    'published_by' => $isPublished ? $request->user()?->id : null,
                ]);
                $created++;
            }
        }

        fclose($handle);

        AdminActivity::query()->create([
            'actor_id' => $request->user()?->id,
            'icon' => '⬆️',
            'description' => 'Import CSV kosakata',
            'action' => 'vocab.import',
            'subject_type' => VocabWord::class,
            'properties' => [
                'rows' => $count,
                'created' => $created,
                'updated' => $updated,
            ],
        ]);

        return redirect()
            ->route('admin.home', ['view' => 'kosakata'])
            ->with('status', "Import selesai. Dibaca {$count} baris, dibuat {$created}, diperbarui {$updated}.");
    }
}
