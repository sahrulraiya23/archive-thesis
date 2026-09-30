<?php

namespace Database\Seeders;

use App\Models\Thesis;
use Illuminate\Database\Seeder;

class ThesisSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/theses_consolidated.json');
        if (!file_exists($file)) {
            throw new \RuntimeException("Data tugas akhir tidak ditemukan: {$file}");
        }

        $items = json_decode(file_get_contents($file), true);

        Thesis::query()->delete();

        foreach ($items as $item) {
            $title = preg_replace('/\s+/', ' ', trim($item['title']));
            $keywords = trim($item['keywords'] ?? '');
            if (empty($keywords)) {
                $keywords = Thesis::extractKeywordsFromTitle($title, 5);
            }

            Thesis::create([
                'title' => $title,
                'keywords' => $keywords,
                'abstract' => $item['abstract'] ?? 'Abstrak belum tersedia.',
                'author' => trim($item['author']),
                'nim' => !empty($item['nim']) ? trim($item['nim']) : null,
                'program_study' => $item['program_study'] ?? 'S1 Teknik Informatika',
                'angkatan' => (int) ($item['angkatan'] ?? 2022),
                'pembimbing_1' => !empty($item['pembimbing_1']) ? trim($item['pembimbing_1']) : null,
                'pembimbing_2' => !empty($item['pembimbing_2']) ? trim($item['pembimbing_2']) : null,
            ]);
        }
    }
}
