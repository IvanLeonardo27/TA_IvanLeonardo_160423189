<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TestingUserSeeder::class,
            VocabularyCategorySeeder::class,
            RealVocabularySeeder::class,
            BatchSeeder281To490::class,
            BatchSeeder491To820::class,
            BatchSeeder821To1300::class,
            BatchSeeder1301To1740::class,
            BatchSeeder1741To1875::class,
            UserAddedVocabularySeeder::class,
            WayangSeeder::class,
            MacapatSeeder::class,
            JavaneseScriptSeeder::class,
            JavaneseScriptExampleSeeder::class,
            DummyDataSeeder::class,
        ]);
    }
}
