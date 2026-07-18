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
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
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
            'type' => 'required|in:skripsi,tesis,disertasi',
            'author' => 'required|string|max:255',
            'program_study' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

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
            'type' => 'required|in:skripsi,tesis,disertasi',
            'author' => 'required|string|max:255',
            'program_study' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

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
}
