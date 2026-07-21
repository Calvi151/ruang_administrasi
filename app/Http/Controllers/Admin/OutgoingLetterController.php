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
        
        if ($request->has('letter_type_id') && $request->letter_type_id) {
            $query->where('letter_type_id', $request->letter_type_id);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        
        $letters = $query->paginate(10)->withQueryString();
        $letterTypes = LetterType::all();
        
        return view('admin.outgoing_letters.index', compact('letters', 'letterTypes'));
    }

    public function create()
    {
        $letterTypes = LetterType::all();
        
        $nextLetterNumbers = [];
        $now = \Carbon\Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $romanMonth = $this->getRomanMonth($month);
        $companyCode = env('COMPANY_CODE', 'TAP');
        
        foreach ($letterTypes as $type) {
            $nextSeq = $this->getNextSequenceNumber($type->id, $year);
            $noUrut = str_pad($nextSeq, 2, '0', STR_PAD_LEFT);
            $nextLetterNumbers[$type->id] = "{$noUrut}/{$type->letter_code}/{$companyCode}/{$romanMonth}/{$year}";
        }

        return view('admin.outgoing_letters.create', compact('letterTypes', 'nextLetterNumbers'));
    }

    private function getRomanMonth($monthNumber)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[(int)$monthNumber];
    }

    private function getNextSequenceNumber($letterTypeId, $year)
    {
        // Cari semua nomor surat untuk jenis dan tahun ini
        $letters = OutgoingLetter::where('letter_type_id', $letterTypeId)
                                 ->whereYear('created_at', $year)
                                 ->get(['letter_number']);
        
        $maxNum = 0;
        foreach ($letters as $letter) {
            $parts = explode('/', $letter->letter_number);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $num = (int)$parts[0];
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }
        
        return $maxNum + 1;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient' => 'required|string',
            'date_sent' => 'required|date',
            'letter_type_id' => 'required|exists:letter_type,id',
            'subject' => 'required|string',
            'content' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);



        // Generate Nomor Surat Otomatis
        // Format: {No urut}/{kodesurat}/TAP/{bulan_romawi}/{Tahun}
        // Menggunakan tanggal hari ini (saat surat diregister/dibuat) untuk penomoran
        $now = \Carbon\Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $romanMonth = $this->getRomanMonth($month);
        
        $letterType = LetterType::find($validated['letter_type_id']);
        $kodeSurat = $letterType->letter_code;

        // Cari nomor urut berdasarkan jenis surat
        $nextSeq = $this->getNextSequenceNumber($letterType->id, $year);
        $noUrut = str_pad($nextSeq, 2, '0', STR_PAD_LEFT);

        $companyCode = env('COMPANY_CODE', 'TAP');

        $letterNumber = "{$noUrut}/{$kodeSurat}/{$companyCode}/{$romanMonth}/{$year}";

        $validated['letter_number'] = $letterNumber;
        
        // Ganti placeholder [NOMOR_SURAT] dengan nomor surat asli di konten
        $validated['content'] = str_replace('[NOMOR_SURAT]', $letterNumber, $validated['content']);
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
            'letter_type_id' => 'required|exists:letter_type,id',
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
        // Mari kita perbarui kode surat jika jenis berubah, tetapi pertahankan nomor urut dan bulan/tahun pembuatannya.
        
        $date = \Carbon\Carbon::parse($outgoingLetter->created_at);
        $year = $date->year;
        $month = $date->month;
        $romanMonth = $this->getRomanMonth($month);
        
        $letterType = LetterType::find($validated['letter_type_id']);
        $kodeSurat = $letterType->letter_code;

        $parts = explode('/', $outgoingLetter->letter_number);
        $noUrut = str_pad($parts[0] ?? $outgoingLetter->id, 2, '0', STR_PAD_LEFT); 

        $companyCode = env('COMPANY_CODE', 'TAP');
        $newLetterNumber = "{$noUrut}/{$kodeSurat}/{$companyCode}/{$romanMonth}/{$year}";
        $validated['letter_number'] = $newLetterNumber;
        
        // Cek apakah user menambahkan [NOMOR_SURAT] yang perlu di-replace
        $validated['content'] = str_replace('[NOMOR_SURAT]', $newLetterNumber, $validated['content']);

        $outgoingLetter->update($validated);

        return redirect()->route('outgoing-letters.index')->with('success', 'Surat Keluar berhasil diperbarui.');
    }

    public function destroy(OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status === 'acc') {
            return redirect()->route('outgoing-letters.index')->with('error', 'Surat yang sudah disetujui (ACC) tidak dapat dihapus.');
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
