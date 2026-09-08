<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thesis;
use Illuminate\Http\Request;

class ThesisController extends Controller
{
    public function index(Request $request)
    {
        $query = Thesis::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('keywords', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $theses = $query->orderBy('created_at', 'desc')->paginate(10);
        $years = Thesis::selectRaw('DISTINCT year')->orderBy('year', 'desc')->pluck('year');

        return view('admin.thesis.index', compact('theses', 'years'));
    }

    public function create()
    {
        return view('admin.thesis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:1000',
            'keywords' => 'nullable|string|max:1000',
            'abstract' => 'required|string',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $kwInput = trim($validated['keywords'] ?? '');
        if ($kwInput !== '') {
            $items = array_values(array_filter(array_map('trim', preg_split('/[,;]+/', $kwInput)), fn($w) => $w !== ''));
            if (!empty($items)) {
                $validated['keywords'] = implode(', ', array_slice($items, 0, 5));
            } else {
                $validated['keywords'] = Thesis::extractKeywordsFromTitle($validated['title'], 5);
            }
        } else {
            $validated['keywords'] = Thesis::extractKeywordsFromTitle($validated['title'], 5);
        }

        $validated['program_study'] = 'S1 Teknik Informatika';

        Thesis::create($validated);

        return redirect()->route('admin.thesis.index')
            ->with('success', 'Tugas akhir berhasil ditambahkan.');
    }

    public function show(Thesis $thesis)
    {
        return view('admin.thesis.show', compact('thesis'));
    }

    public function edit(Thesis $thesis)
    {
        return view('admin.thesis.create', compact('thesis'));
    }

    public function update(Request $request, Thesis $thesis)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:1000',
            'keywords' => 'nullable|string|max:1000',
            'abstract' => 'required|string',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $kwInput = trim($validated['keywords'] ?? '');
        if ($kwInput !== '') {
            $items = array_values(array_filter(array_map('trim', preg_split('/[,;]+/', $kwInput)), fn($w) => $w !== ''));
            if (!empty($items)) {
                $validated['keywords'] = implode(', ', array_slice($items, 0, 5));
            } else {
                $validated['keywords'] = Thesis::extractKeywordsFromTitle($validated['title'], 5);
            }
        } else {
            $validated['keywords'] = Thesis::extractKeywordsFromTitle($validated['title'], 5);
        }

        $validated['program_study'] = 'S1 Teknik Informatika';

        $thesis->update($validated);

        return redirect()->route('admin.thesis.index')
            ->with('success', 'Tugas akhir berhasil diperbarui.');
    }

    public function destroy(Thesis $thesis)
    {
        $thesis->delete();

        return redirect()->route('admin.thesis.index')
            ->with('success', 'Tugas akhir berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $query = Thesis::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('keywords', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $theses = $query->orderBy('created_at', 'desc')->get();

        $filename = 'arsip-tugas-akhir-' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($theses) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No', 'Judul', 'Kata Kunci', 'Penulis', 'Tahun', 'Abstrak', 'Tanggal Input']);

            foreach ($theses as $index => $thesis) {
                fputcsv($file, [
                    $index + 1,
                    $thesis->title,
                    $thesis->keywords,
                    $thesis->author,
                    $thesis->year,
                    $thesis->abstract,
                    $thesis->created_at ? $thesis->created_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
