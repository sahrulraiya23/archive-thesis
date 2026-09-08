<?php

namespace Database\Seeders;

use App\Models\Thesis;
use Illuminate\Database\Seeder;

class ThesisSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/theses-2026.csv');
        $handle = fopen($file, 'r');

        if ($handle === false) {
            throw new \RuntimeException("Data tugas akhir tidak ditemukan: {$file}");
        }

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 5 || blank($row[4])) {
                continue;
            }

            $title = preg_replace('/\s+/', ' ', trim($row[4]));
            $keywordsStr = Thesis::extractKeywordsFromTitle($title, 5);

            Thesis::create([
                'title' => $title,
                'keywords' => $keywordsStr,
                'abstract' => 'Abstrak belum tersedia.',
                'author' => trim($row[1]),
                'nim' => trim($row[0]),
                'program_study' => trim($row[2]),
                'year' => 2026,
            ]);
        }

        fclose($handle);
    }
}
