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
            // Format CSV: NIM, nama, program studi, status ujian, judul.
            // Status ujian sengaja tidak diimpor.
            if (count($row) < 5 || blank($row[4])) {
                continue;
            }

            Thesis::create([
                'title' => preg_replace('/\s+/', ' ', trim($row[4])),
                'abstract' => 'Abstrak belum tersedia.',
                'type' => 'skripsi',
                'author' => trim($row[1]),
                'program_study' => trim($row[2]),
                'year' => 2026,
            ]);
        }

        fclose($handle);
    }
}
