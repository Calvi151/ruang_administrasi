<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use Illuminate\Http\Request;

class LetterTypeController extends Controller
{
    public function index()
    {
        $types = LetterType::withCount('outgoingLetters')->get();
        return view('admin.letter_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.letter_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_code' => 'required|string|max:30|unique:letter_type,letter_code',
            'type_name'   => 'required|string|max:255',
            'template'    => 'nullable|string',
        ], [
            'letter_code.unique' => 'Kode surat tersebut sudah ada di sistem! Gunakan kombinasi atau akhiran lain agar tidak duplikat (Contoh: SKET / SKP / SKU).'
        ]);

        LetterType::create($validated);
        return redirect()->route('letter-types.index')->with('success', 'Jenis Surat baru berhasil ditambahkan tanpa duplikasi.');
    }

    public function show(LetterType $letterType)
    {
        return redirect()->route('letter-types.index');
    }

    public function edit(LetterType $letterType)
    {
        $letterType->loadCount('outgoingLetters');
        return view('admin.letter_types.edit', compact('letterType'));
    }

    public function update(Request $request, LetterType $letterType)
    {
        $validated = $request->validate([
            'letter_code' => 'required|string|max:30|unique:letter_type,letter_code,' . $letterType->id,
            'type_name'   => 'required|string|max:255',
            'template'    => 'nullable|string',
        ], [
            'letter_code.unique' => 'Kode surat tersebut sudah terpakai oleh jenis surat lain! Harap gunakan kode yang belum terpakai.'
        ]);

        $letterType->update($validated);
        return redirect()->route('letter-types.index')->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    public function destroy(LetterType $letterType)
    {
        if ($letterType->outgoingLetters()->count() > 0) {
            return redirect()->route('letter-types.index')->with('error', 'Jenis Surat tidak dapat dihapus karena sudah terikat dengan ' . $letterType->outgoingLetters()->count() . ' dokumen surat keluar.');
        }

        $letterType->delete();
        return redirect()->route('letter-types.index')->with('success', 'Jenis Surat berhasil dihapus.');
    }
}
