<?php

namespace Database\Seeders;

use App\Models\VocabularyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VocabularyCategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil semua string kategori unik dari tabel vocabularies
        $categoriesInVocab = DB::table('vocabularies')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category')
            ->unique()
            ->values();

        // Kategori paten utama
        $defaultCategories = [
            'Kata Benda',
            'Kata Sifat',
            'Kata Kerja',
            'Kata Bilangan',
            'Kata Keterangan',
            'Kata Hubung',
            'Kata Depan',
            'Kata Tanya',
            'Sapaan',
            'Ungkapan',
            'Unggah-ungguh',
            'Anggota Tubuh',
            'Keluarga',
            'Makanan',
            'Minuman',
            'Hewan',
            'Tumbuhan',
            'Pohon',
            'Buah',
            'Sayuran',
            'Bunga',
            'Alam',
            'Cuaca',
            'Kesehatan',
            'Pendidikan',
            'Sekolah',
            'Profesi',
            'Pekerjaan',
            'Rumah',
            'Peralatan Rumah',
            'Peralatan Dapur',
            'Dapur',
            'Aksesori',
            'Pakaian',
            'Perasaan',
            'Teknologi',
            'Komputer',
            'Internet',
            'Transportasi',
            'Kendaraan',
            'Tempat Umum',
            'Tempat',
            'Bangunan',
            'Olahraga',
            'Seni',
            'Musik',
            'Hiburan',
            'Budaya',
            'Agama',
            'Ekonomi',
            'Perdagangan',
            'Sejarah',
            'Sains',
            'Matematika',
            'Bahasa',
            'Tata Bahasa',
            'Mata Pelajaran',
            'Organisasi',
            'Sosial',
            'Lingkungan',
            'Penyakit',
            'Obat',
            'Geografi',
            'Dokumen',
            'Alat Tulis',
            'Aktivitas',
            'Kerajinan',
            'Arah',
            'Cerita',
            'Benda',
            'Waktu',
            'Warna',
            'Kegiatan',
            'Bentuk',
            'Permainan',
            'Istilah Modern',
            'Keamanan',
            'Hukum',
            'Pemerintahan'
        ];

        $allCategories = $categoriesInVocab->merge($defaultCategories)->unique()->sort()->values();

        foreach ($allCategories as $catName) {
            $cat = VocabularyCategory::firstOrCreate(
                ['name' => trim($catName)],
                ['description' => 'Kategori ' . trim($catName)]
            );
        }

        // 2. Hubungkan vocabularies.category_id berdasarkan string category yang ada
        $allDbCategories = VocabularyCategory::pluck('id', 'name');

        foreach ($allDbCategories as $name => $id) {
            DB::table('vocabularies')
                ->where('category', $name)
                ->update(['category_id' => $id]);
        }
    }
}
