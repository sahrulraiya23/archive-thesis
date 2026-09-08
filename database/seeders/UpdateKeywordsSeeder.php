<?php

namespace Database\Seeders;

use App\Models\Thesis;
use Illuminate\Database\Seeder;

class UpdateKeywordsSeeder extends Seeder
{
    public function run(): void
    {
        $theses = Thesis::all();
        foreach ($theses as $thesis) {
            $extracted = Thesis::extractKeywordsFromTitle($thesis->title, 5);
            $thesis->update([
                'keywords' => $extracted,
            ]);
        }
    }
}
