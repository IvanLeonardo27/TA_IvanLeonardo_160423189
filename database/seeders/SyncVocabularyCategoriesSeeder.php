<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use App\Models\VocabularyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncVocabularyCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        // 1. Ambil semua kategori dari DB
        $categoryMap = VocabularyCategory::pluck('id', 'name')->toArray();

        // Kategori default jika null/kosong
        $defaultCatId = $categoryMap['Umum'] ?? VocabularyCategory::firstOrCreate(['name' => 'Umum'], ['description' => 'Kategori Umum'])->id;

        // 2. Ambil semua vocabularies
        $vocabularies = Vocabulary::all();

        $updatedCount = 0;

        foreach ($vocabularies as $vocab) {
            $catName = trim($vocab->category ?? '');

            if (empty($catName) || $catName === 'NULL') {
                $catName = 'Umum';
            }

            // Jika kategori belum ada di database, buat kategori baru secara otomatis
            if (!isset($categoryMap[$catName])) {
                $newCat = VocabularyCategory::firstOrCreate(
                    ['name' => $catName],
                    ['description' => 'Kategori ' . $catName]
                );
                $categoryMap[$catName] = $newCat->id;
            }

            $catId = $categoryMap[$catName];

            // Update category_id dan pastikan kolom string category konsisten
            if ($vocab->category_id !== $catId || $vocab->category !== $catName) {
                $vocab->update([
                    'category_id' => $catId,
                    'category'    => $catName
                ]);
                $updatedCount++;
            }
        }

        $this->command->info("Berhasil menyinkronkan {$updatedCount} kosakata dengan kategori yang sesuai.");
    }
}
