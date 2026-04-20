<?php

namespace Database\Seeders;

use App\Models\AdminActivity;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\QuizSet;
use App\Models\VocabCategory;
use App\Models\VocabWord;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SinauBasaSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $angka = VocabCategory::firstOrCreate(['slug' => 'angka'], ['name' => 'Angka']);
        $hewan = VocabCategory::firstOrCreate(['slug' => 'hewan'], ['name' => 'Hewan']);
        $tubuh = VocabCategory::firstOrCreate(['slug' => 'tubuh'], ['name' => 'Anggota Tubuh']);
        $umum = VocabCategory::firstOrCreate(['slug' => 'umum'], ['name' => 'Umum']);

        // Words (from your mock data)
        $words = [
            // Angka
            [$angka->id, 'Satu', 'Siji', '1️⃣'],
            [$angka->id, 'Dua', 'Loro', '2️⃣'],
            [$angka->id, 'Tiga', 'Telu', '3️⃣'],
            [$angka->id, 'Empat', 'Papat', '4️⃣'],
            [$angka->id, 'Lima', 'Limo', '5️⃣'],
            [$angka->id, 'Enam', 'Nem', '6️⃣'],

            // Hewan
            [$hewan->id, 'Kucing', 'Kucing', '🐱'],
            [$hewan->id, 'Kuda', 'Jaran', '🐎'],
            [$hewan->id, 'Gajah', 'Gajah', '🐘'],
            [$hewan->id, 'Ayam', 'Pitik', '🐔'],
            [$hewan->id, 'Kerbau', 'Kebo', '🐃'],
            [$hewan->id, 'Ikan', 'Iwak', '🐟'],

            // Tubuh
            [$tubuh->id, 'Kepala', 'Sirah', '🧑'],
            [$tubuh->id, 'Mata', 'Mripat', '👁️'],
            [$tubuh->id, 'Hidung', 'Irung', '👃'],
            [$tubuh->id, 'Tangan', 'Tangan', '✋'],
            [$tubuh->id, 'Kaki', 'Sikil', '🦶'],
            [$tubuh->id, 'Gigi', 'Untu', '🦷'],

            // Umum (translate)
            [$umum->id, 'makan', 'Mangan', null],
            [$umum->id, 'minum', 'Ngombe', null],
            [$umum->id, 'tidur', 'Turu', null],
            [$umum->id, 'pergi', 'Lungo', null],
            [$umum->id, 'pulang', 'Bali', null],
            [$umum->id, 'datang', 'Teko', null],
            [$umum->id, 'buku', 'Buku', null],
            [$umum->id, 'sekolah', 'Sekolah', null],
            [$umum->id, 'ibu', 'Ibu / Simbok', null],
            [$umum->id, 'ayah', 'Bapak', null],
            [$umum->id, 'kakak', 'Kangmas / Mbakyu', null],
            [$umum->id, 'adik', 'Adik', null],
            [$umum->id, 'saya', 'Aku', null],
            [$umum->id, 'kamu', 'Kowe', null],
            [$umum->id, 'lari', 'Mlayu', null],
        ];

        foreach ($words as [$categoryId, $indo, $jawa, $emoji]) {
            VocabWord::firstOrCreate(
                ['vocab_category_id' => $categoryId, 'indo' => $indo],
                ['jawa' => $jawa, 'emoji' => $emoji, 'is_published' => true]
            );
        }

        // Quiz sets + questions
        $quizAngka = QuizSet::firstOrCreate(
            ['slug' => 'kuis-angka-dasar'],
            ['title' => 'Kuis Angka Dasar', 'is_active' => true, 'is_default' => true]
        );

        $quizHewan = QuizSet::firstOrCreate(
            ['slug' => 'kuis-hewan'],
            ['title' => 'Kuis Hewan', 'is_active' => true, 'is_default' => false]
        );

        $questionsAngka = [
            [
                'question' => 'Apa arti kata "Siji" dalam Bahasa Indonesia?',
                'options' => ['Satu', 'Dua', 'Tiga', 'Empat'],
                'correct_index' => 0,
            ],
            [
                'question' => 'Bahasa Jawanya "Mata" adalah...',
                'options' => ['Irung', 'Mripat', 'Untu', 'Kuping'],
                'correct_index' => 1,
            ],
            [
                'question' => 'Kalo "Kucing" dalam Bahasa Jawa tetap disebut...',
                'options' => ['Jaran', 'Kebo', 'Kucing', 'Pitik'],
                'correct_index' => 2,
            ],
            [
                'question' => '"Bapak tindak kantor". Tindak artinya...',
                'options' => ['Pulang', 'Tidur', 'Pergi', 'Makan'],
                'correct_index' => 2,
            ],
            [
                'question' => 'Bahasa Jawanya Angka 5 adalah...',
                'options' => ['Papat', 'Limo', 'Nem', 'Pitu'],
                'correct_index' => 1,
            ],
        ];

        foreach ($questionsAngka as $q) {
            QuizQuestion::firstOrCreate(
                ['quiz_set_id' => $quizAngka->id, 'question' => $q['question']],
                [
                    'options' => $q['options'],
                    'correct_index' => $q['correct_index'],
                    'is_active' => true,
                ]
            );
        }

        $questionsHewan = [
            [
                'question' => 'Bahasa Jawanya "Kuda" adalah...',
                'options' => ['Jaran', 'Kebo', 'Pitik', 'Iwak'],
                'correct_index' => 0,
            ],
            [
                'question' => '"Iwak" artinya...',
                'options' => ['Kerbau', 'Ikan', 'Gajah', 'Ayam'],
                'correct_index' => 1,
            ],
        ];

        foreach ($questionsHewan as $q) {
            QuizQuestion::firstOrCreate(
                ['quiz_set_id' => $quizHewan->id, 'question' => $q['question']],
                [
                    'options' => $q['options'],
                    'correct_index' => $q['correct_index'],
                    'is_active' => true,
                ]
            );
        }

        // Admin activities (sample)
        AdminActivity::firstOrCreate(
            ['description' => 'Menambah Kosakata baru "Krama Alus"'],
            ['icon' => '📝']
        );
        AdminActivity::firstOrCreate(
            ['description' => 'Update Soal Kuis Angka'],
            ['icon' => '✅']
        );

        // Attempts (sample)
        $now = Carbon::now();
        QuizAttempt::firstOrCreate(
            ['quiz_set_id' => $quizAngka->id, 'player_name' => 'Rizky Ramadhan', 'taken_at' => $now->copy()->subDays(1)],
            ['score' => 100]
        );
        QuizAttempt::firstOrCreate(
            ['quiz_set_id' => $quizHewan->id, 'player_name' => 'Siti Aminah', 'taken_at' => $now->copy()->subDays(2)],
            ['score' => 80]
        );
        QuizAttempt::firstOrCreate(
            ['quiz_set_id' => $quizAngka->id, 'player_name' => 'Anindita Putri', 'taken_at' => $now->copy()->subDays(3)],
            ['score' => 100]
        );
        QuizAttempt::firstOrCreate(
            ['quiz_set_id' => $quizAngka->id, 'player_name' => 'Budi Santoso', 'taken_at' => $now->copy()->subDays(4)],
            ['score' => 98]
        );
    }
}