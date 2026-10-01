<?php

namespace Database\Seeders;

use App\Models\Thesis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ThesisSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/theses_consolidated.json');
        if (!file_exists($file)) {
            throw new \RuntimeException("Data tugas akhir tidak ditemukan: {$file}");
        }

        $items = json_decode(file_get_contents($file), true);
        if (!is_array($items)) {
            throw new \RuntimeException("Format file JSON tugas akhir tidak valid: {$file}");
        }

        Schema::disableForeignKeyConstraints();
        Thesis::truncate();
        Schema::enableForeignKeyConstraints();

        $now = now();
        $batch = [];

        foreach ($items as $item) {
            $title = preg_replace('/\s+/', ' ', trim($item['title'] ?? ''));
            if (empty($title)) {
                continue;
            }

            $keywords = trim($item['keywords'] ?? '');
            if (empty($keywords)) {
                $keywords = Thesis::extractKeywordsFromTitle($title, 5);
            }

            $batch[] = [
                'id' => $item['id'] ?? null,
                'title' => $title,
                'keywords' => $keywords,
                'abstract' => $item['abstract'] ?? 'Abstrak belum tersedia.',
                'author' => trim($item['author'] ?? '-'),
                'nim' => !empty($item['nim']) ? trim($item['nim']) : null,
                'program_study' => $item['program_study'] ?? 'S1 Teknik Informatika',
                'angkatan' => (int) ($item['angkatan'] ?? 2022),
                'pembimbing_1' => !empty($item['pembimbing_1']) ? trim($item['pembimbing_1']) : null,
                'pembimbing_2' => !empty($item['pembimbing_2']) ? trim($item['pembimbing_2']) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::transaction(function () use ($batch) {
            foreach (array_chunk($batch, 50) as $chunk) {
                DB::table('thesis')->insert($chunk);
            }
        });

        $this->command?->info("Berhasil mengimpor " . count($batch) . " data tugas akhir.");
    }
}
