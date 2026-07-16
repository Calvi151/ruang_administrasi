<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use Illuminate\Http\Request;

class LetterTypeController extends Controller
{
    public function index()
    {
        $types = LetterType::all();
        return view('admin.letter_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.letter_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_code' => 'required|string|unique:letter_type',
            'type_name' => 'required|string',
            'template' => 'nullable|string',
        ]);

        LetterType::create($validated);
        return redirect()->route('letter-types.index')->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    public function show(LetterType $letterType)
    {
        // Untuk master data yang sederhana, biasanya tidak butuh halaman detail khusus
        return redirect()->route('letter-types.index');
    }

    public function edit(LetterType $letterType)
    {
        return view('admin.letter_types.edit', compact('letterType'));
    }

    public function update(Request $request, LetterType $letterType)
    {
        $validated = $request->validate([
            'letter_code' => 'required|string|unique:letter_type,letter_code,' . $letterType->id,
            'type_name' => 'required|string',
            'template' => 'nullable|string',
        ]);

        $letterType->update($validated);
        return redirect()->route('letter-types.index')->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    public function destroy(LetterType $letterType)
    {
        // Cek apakah jenis surat sedang digunakan di surat keluar (opsional, jika relasi sudah didefinisikan ketat)
        $letterType->delete();
        return redirect()->route('letter-types.index')->with('success', 'Jenis Surat berhasil dihapus.');
    }
}
