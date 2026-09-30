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
                    ->orWhere('nim', 'like', '%' . $search . '%')
                    ->orWhere('keywords', 'like', '%' . $search . '%')
                    ->orWhere('pembimbing_1', 'like', '%' . $search . '%')
                    ->orWhere('pembimbing_2', 'like', '%' . $search . '%');
            });
        }

        $angkatan = $request->input('angkatan', $request->input('year'));
        if (!empty($angkatan)) {
            $query->where('angkatan', $angkatan);
        }

        $theses = $query->orderBy('created_at', 'desc')->paginate(15);
        $angkatans = Thesis::whereNotNull('angkatan')->selectRaw('DISTINCT angkatan')->orderBy('angkatan', 'desc')->pluck('angkatan');
        $years = $angkatans;

        return view('admin.thesis.index', compact('theses', 'angkatans', 'years'));
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
            'nim' => 'nullable|string|max:50',
            'angkatan' => 'nullable|integer|min:1990|max:2099',
            'year' => 'nullable|integer|min:1990|max:2099',
            'pembimbing_1' => 'nullable|string|max:255',
            'pembimbing_2' => 'nullable|string|max:255',
        ]);

        $validated['angkatan'] = $validated['angkatan'] ?? $validated['year'] ?? date('Y');
        unset($validated['year']);

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
            'nim' => 'nullable|string|max:50',
            'angkatan' => 'nullable|integer|min:1990|max:2099',
            'year' => 'nullable|integer|min:1990|max:2099',
            'pembimbing_1' => 'nullable|string|max:255',
            'pembimbing_2' => 'nullable|string|max:255',
        ]);

        $validated['angkatan'] = $validated['angkatan'] ?? $validated['year'] ?? ($thesis->angkatan ?? date('Y'));
        unset($validated['year']);

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
                    ->orWhere('nim', 'like', '%' . $search . '%')
                    ->orWhere('keywords', 'like', '%' . $search . '%')
                    ->orWhere('pembimbing_1', 'like', '%' . $search . '%')
                    ->orWhere('pembimbing_2', 'like', '%' . $search . '%');
            });
        }

        $angkatan = $request->input('angkatan', $request->input('year'));
        if (!empty($angkatan)) {
            $query->where('angkatan', $angkatan);
        }

        $theses = $query->orderBy('created_at', 'desc')->get();

        $filename = 'arsip-tugas-akhir-angkatan-' . date('Y-m-d_His') . '.csv';

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

            fputcsv($file, ['No', 'NIM', 'Angkatan', 'Penulis', 'Judul', 'Kata Kunci', 'Pembimbing 1', 'Pembimbing 2', 'Program Studi', 'Abstrak', 'Tanggal Input']);

            foreach ($theses as $index => $thesis) {
                fputcsv($file, [
                    $index + 1,
                    $thesis->nim ?: '-',
                    $thesis->angkatan,
                    $thesis->author,
                    $thesis->title,
                    $thesis->keywords,
                    $thesis->pembimbing_1 ?: '-',
                    $thesis->pembimbing_2 ?: '-',
                    $thesis->program_study ?: 'S1 Teknik Informatika',
                    $thesis->abstract,
                    $thesis->created_at ? $thesis->created_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
