<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OutgoingLetter;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OutgoingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = OutgoingLetter::with(['letterType', 'creator'])->orderByDesc('created_at');
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
        }
        
        $letters = $query->paginate(10)->withQueryString();
        return view('admin.outgoing_letters.index', compact('letters'));
    }

    public function create()
    {
        $letterTypes = LetterType::all();
        return view('admin.outgoing_letters.create', compact('letterTypes'));
    }

    private function getRomanMonth($monthNumber)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[(int)$monthNumber];
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient' => 'required|string',
            'date_sent' => 'required|date',
            'letter_type_id' => 'required|exists:letter_types,id',
            'subject' => 'required|string',
            'content' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);



        // Generate Nomor Surat Otomatis
        // Format: {No urut}/{kodesurat}/TAP/{bulan_romawi}/{Tahun}
        // Contoh: 1/012/TAP/VI/2026
        
        $date = Carbon::parse($validated['date_sent']);
        $year = $date->year;
        $month = $date->month;
        $romanMonth = $this->getRomanMonth($month);
        
        $letterType = LetterType::find($validated['letter_type_id']);
        $kodeSurat = $letterType->letter_code;

        // Cari nomor urut terakhir di tahun yang sama
        $lastLetter = OutgoingLetter::whereYear('date_sent', $year)->orderBy('id', 'desc')->first();
        $noUrut = 1;
        if ($lastLetter) {
            // Ambil angka pertama sebelum '/'
            $parts = explode('/', $lastLetter->letter_number);
            if (is_numeric($parts[0])) {
                $noUrut = (int)$parts[0] + 1;
            } else {
                // Fallback jika format lama tidak sesuai
                $noUrut = OutgoingLetter::whereYear('date_sent', $year)->count() + 1;
            }
        }

        $letterNumber = "{$noUrut}/{$kodeSurat}/TAP/{$romanMonth}/{$year}";

        $validated['letter_number'] = $letterNumber;
        $validated['status'] = 'pending'; // Butuh ACC CEO
        $validated['creator_id'] = auth()->id() ?? 1;

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('outgoing_letters', 'public');
        } else {
            unset($validated['file_path']);
        }

        OutgoingLetter::create($validated);

        return redirect()->route('outgoing-letters.index')->with('success', "Surat Keluar berhasil dibuat dengan nomor: {$letterNumber}");
    }

    public function show(OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load(['letterType', 'creator']);
        return view('admin.outgoing_letters.show', compact('outgoingLetter'));
    }

    public function edit(OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return redirect()->route('outgoing-letters.index')->with('error', 'Hanya surat berstatus pending yang dapat diubah.');
        }

        $letterTypes = LetterType::all();
        return view('admin.outgoing_letters.edit', compact('outgoingLetter', 'letterTypes'));
    }

    public function update(Request $request, OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return redirect()->route('outgoing-letters.index')->with('error', 'Hanya surat berstatus pending yang dapat diubah.');
        }

        $validated = $request->validate([
            'recipient' => 'required|string',
            'date_sent' => 'required|date',
            'letter_type_id' => 'required|exists:letter_types,id',
            'subject' => 'required|string',
            'content' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file_path')) {
            if ($outgoingLetter->file_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($outgoingLetter->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('outgoing_letters', 'public');
        } else {
            unset($validated['file_path']);
        }

        // Cek jika jenis surat atau tanggal berubah, kita mungkin perlu mereset nomor urut (opsional)
        // Namun untuk kesederhanaan, nomor surat biasanya dipertahankan kecuali format total berubah.
        // Mari kita perbarui kode surat dan bulan/tahun jika tanggal/jenis berubah, tetapi pertahankan nomor urutnya.
        
        $date = Carbon::parse($validated['date_sent']);
        $year = $date->year;
        $month = $date->month;
        $romanMonth = $this->getRomanMonth($month);
        
        $letterType = LetterType::find($validated['letter_type_id']);
        $kodeSurat = $letterType->letter_code;

        $parts = explode('/', $outgoingLetter->letter_number);
        $noUrut = $parts[0] ?? $outgoingLetter->id; 

        $newLetterNumber = "{$noUrut}/{$kodeSurat}/TAP/{$romanMonth}/{$year}";
        $validated['letter_number'] = $newLetterNumber;

        $outgoingLetter->update($validated);

        return redirect()->route('outgoing-letters.index')->with('success', 'Surat Keluar berhasil diperbarui.');
    }

    public function destroy(OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return redirect()->route('outgoing-letters.index')->with('error', 'Hanya surat berstatus pending yang dapat dihapus.');
        }

        $outgoingLetter->delete();
        return redirect()->route('outgoing-letters.index')->with('success', 'Surat Keluar berhasil dihapus.');
    }

    public function exportPdf(OutgoingLetter $outgoingLetter)
    {
        // Must load relationships
        $outgoingLetter->load(['letterType', 'creator']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.outgoing_letters.print', compact('outgoingLetter'));
        
        // Return file to download
        return $pdf->download(str_replace('/', '_', $outgoingLetter->letter_number) . '.pdf');
    }

    public function exportWord(OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load(['letterType', 'creator']);
        
        $headers = [
            "Content-type" => "application/vnd.ms-word",
            "Content-Disposition" => "attachment;Filename=" . str_replace('/', '_', $outgoingLetter->letter_number) . ".doc"
        ];
        
        return response()->view('admin.outgoing_letters.print', compact('outgoingLetter'), 200, $headers);
    }
}
