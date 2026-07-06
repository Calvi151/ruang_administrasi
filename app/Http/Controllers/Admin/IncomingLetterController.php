<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingLetter::query();
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('sender', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
        }
        $letters = $query->orderByDesc('date_received')->paginate(10)->withQueryString();
        return view('admin.incoming_letters.index', compact('letters'));
    }

    public function create()
    {
        return view('admin.incoming_letters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_number' => 'required|string|unique:incoming_letters',
            'date_received' => 'required|date',
            'sender'        => 'required|string|max:255',
            'subject'       => 'required|string',
            'file'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('incoming_letters', 'public');
        }
        unset($validated['file']);

        IncomingLetter::create($validated);

        return redirect()->route('incoming-letters.index')
                         ->with('success', 'Surat Masuk berhasil diarsipkan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        return view('admin.incoming_letters.show', compact('incomingLetter'));
    }

    public function edit(IncomingLetter $incomingLetter)
    {
        return view('admin.incoming_letters.edit', compact('incomingLetter'));
    }

    public function update(Request $request, IncomingLetter $incomingLetter)
    {
        $validated = $request->validate([
            'letter_number' => 'required|string|unique:incoming_letters,letter_number,' . $incomingLetter->id,
            'date_received' => 'required|date',
            'sender'        => 'required|string|max:255',
            'subject'       => 'required|string',
            'file'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            if ($incomingLetter->file_path) {
                Storage::disk('public')->delete($incomingLetter->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('incoming_letters', 'public');
        }
        unset($validated['file']);

        $incomingLetter->update($validated);

        return redirect()->route('incoming-letters.index')
                         ->with('success', 'Surat Masuk berhasil diperbarui.');
    }

    public function destroy(IncomingLetter $incomingLetter)
    {
        if ($incomingLetter->file_path) {
            Storage::disk('public')->delete($incomingLetter->file_path);
        }
        $incomingLetter->delete();

        return redirect()->route('incoming-letters.index')
                         ->with('success', 'Surat Masuk berhasil dihapus.');
    }
}
