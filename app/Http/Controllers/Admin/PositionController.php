<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::withCount('employees')->orderBy('name', 'asc')->get();
        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Nama jabatan ini sudah ada di sistem.',
            'name.required' => 'Nama jabatan wajib diisi.',
        ]);

        Position::create($validated);
        return redirect()->route('positions.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,' . $position->id,
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Nama jabatan ini sudah terpakai.',
            'name.required' => 'Nama jabatan wajib diisi.',
        ]);

        $position->update($validated);
        return redirect()->route('positions.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        if ($position->employees()->count() > 0) {
            return redirect()->route('positions.index')->with('error', 'Tidak dapat menghapus jabatan ini karena masih ada karyawan yang menggunakannya.');
        }

        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
