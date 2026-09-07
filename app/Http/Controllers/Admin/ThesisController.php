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
                    ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', strtolower(trim($request->type)));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $theses = $query->orderBy('created_at', 'desc')->paginate(10);
        $types = Thesis::getTypes();
        $years = Thesis::selectRaw('DISTINCT year')->orderBy('year', 'desc')->pluck('year');

        return view('admin.thesis.index', compact('theses', 'types', 'years'));
    }

    public function create()
    {
        $types = Thesis::getTypes();
        return view('admin.thesis.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'type' => 'required|in:kcv,kbj,rpl',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

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
        $types = Thesis::getTypes();
        return view('admin.thesis.edit', compact('thesis', 'types'));
    }

    public function update(Request $request, Thesis $thesis)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'type' => 'required|in:kcv,kbj,rpl',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

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
                    ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', strtolower(trim($request->type)));
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

            fputcsv($file, ['No', 'Judul', 'Penulis', 'Peminatan Kode', 'Peminatan', 'Tahun', 'Abstrak', 'Tanggal Input']);

            foreach ($theses as $index => $thesis) {
                fputcsv($file, [
                    $index + 1,
                    $thesis->title,
                    $thesis->author,
                    $thesis->type_code_upper,
                    $thesis->type_label,
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
