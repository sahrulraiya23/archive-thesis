<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $totalThesis = \App\Models\Thesis::count();
        $thisYearThesis = \App\Models\Thesis::whereYear('created_at', date('Y'))->count();
        return view('public.home', compact('totalThesis', 'thisYearThesis'));
    }

    public function thesisIndex(Request $request)
    {
        $query = Thesis::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', strtolower(trim($request->type)));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $theses = $query->orderBy('created_at', 'desc')->paginate(12);
        $types = Thesis::getTypes();
        $years = Thesis::selectRaw('DISTINCT year')->orderBy('year', 'desc')->pluck('year');

        return view('public.index', compact('theses', 'types', 'years'));
    }

    public function thesisShow(Thesis $thesis)
    {
        return view('public.show', compact('thesis'));
    }

    public function plagiarismCheck()
    {
        return view('public.plagiarism');
    }

    public function checkPlagiarism(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $inputTitle = strtolower(trim($request->title));
        $words1 = $this->importantWords($inputTitle);
        $allTheses = Thesis::all();

        $similarities = [];

        foreach ($allTheses as $thesis) {
            $existingTitle = strtolower(trim($thesis->title));
            $words2 = $this->importantWords($existingTitle);

            if (empty($words1) || empty($words2)) {
                continue;
            }

            $sharedWords = array_values(array_intersect($words1, $words2));
            if (empty($sharedWords)) {
                continue;
            }

            $allWords = array_unique(array_merge($words1, $words2));
            $similarity = round((count($sharedWords) / count($allWords)) * 100, 2);

            if ($similarity > 0) {
                $similarities[] = [
                    'thesis' => $thesis,
                    'percentage' => $similarity,
                    'sharedWords' => $sharedWords,
                ];
            }
        }

        // Sort by similarity percentage (descending)
        usort($similarities, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        $maxSimilarity = !empty($similarities) ? $similarities[0]['percentage'] : 0;

        return view('public.plagiarism', [
            'inputTitle' => $request->title,
            'similarities' => $similarities,
            'maxSimilarity' => $maxSimilarity
        ]);
    }

    private function calculateSimilarity(string $str1, string $str2): float
    {
        $words1 = $this->importantWords($str1);
        $words2 = $this->importantWords($str2);

        if (empty($words1) || empty($words2)) {
            return 0;
        }

        $sharedWords = array_intersect($words1, $words2);
        $allWords = array_unique(array_merge($words1, $words2));

        // Jaccard similarity: only words shared by both titles contribute.
        return round((count($sharedWords) / count($allWords)) * 100, 2);
    }

    private function importantWords(string $title): array
    {
        $normalizedTitle = mb_strtolower($title);
        $normalizedTitle = preg_replace('/[^\\p{L}\\p{N}]+/u', ' ', $normalizedTitle);

        $stopWords = [
            'dan', 'atau', 'yang', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada', 'dalam',
            'oleh', 'terhadap', 'antara', 'sebagai', 'studi', 'kasus', 'berbasis', 'menggunakan',
            'penerapan', 'implementasi', 'pengembangan', 'perancangan', 'rancang', 'bangun',
            'analisis', 'sistem', 'aplikasi', 'metode', 'algoritma', 'model', 'data', 'the', 'of',
            'and', 'for', 'with', 'in', 'to', 'a', 'an', 'based', 'using', 'on',
        ];

        return array_values(array_unique(array_filter(
            explode(' ', trim($normalizedTitle)),
            fn (string $word): bool => mb_strlen($word) > 2 && !in_array($word, $stopWords, true)
        )));
    }
}
