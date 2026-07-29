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
        $query = OutgoingLetter::with(['letterType', 'creator', 'incomingLetter'])->orderByDesc('created_at');
        
        if ($request->has('letter_type_id') && $request->letter_type_id) {
            $query->where('letter_type_id', $request->letter_type_id);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhereHas('incomingLetter', function($sub) use ($search) {
                      $sub->where('letter_number', 'like', "%{$search}%")
                          ->orWhere('sender', 'like', "%{$search}%");
                  });
            });
        }
        
        $letters = $query->paginate(10)->withQueryString();
        $letterTypes = LetterType::all();
        
        // Stats counts
        $totalAll = OutgoingLetter::count();
        $countUmum = OutgoingLetter::where('category', 'umum')->count();
        $countBalasan = OutgoingLetter::where('category', 'balasan')->count();

        return view('admin.outgoing_letters.index', compact('letters', 'letterTypes', 'totalAll', 'countUmum', 'countBalasan'));
    }

    public function create(Request $request)
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

        $replyTo = null;
        if ($request->filled('reply_to')) {
            $replyTo = \App\Models\IncomingLetter::find($request->reply_to);
        }

        // Hanya sertakan Surat Masuk yang BELUM dibalas (atau yang sedang dipilih via parameter reply_to)
        $incomingLetters = \App\Models\IncomingLetter::whereDoesntHave('replies')
            ->when($request->filled('reply_to'), function($query) use ($request) {
                $query->orWhere('id', $request->reply_to);
            })
            ->orderByDesc('date_received')
            ->get();

        return view('admin.outgoing_letters.create', compact('letterTypes', 'nextLetterNumbers', 'replyTo', 'incomingLetters'));
    }

    private function getRomanMonth($monthNumber)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[(int)$monthNumber];
    }

    private function getNextSequenceNumber($letterCode, $year)
    {
        // Cari semua nomor surat yang mengandung KODE SURAT yang sama di tahun yang sama
        // Agar jika ada banyak jenis surat dengan kode (misal "SK") yang sama, urutannya tetap berlanjut (tidak reset ke 1)
        $letters = OutgoingLetter::where('letter_number', 'LIKE', "%/{$letterCode}/%/{$year}")
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
            'category' => 'nullable|in:umum,balasan',
            'incoming_letter_id' => 'nullable|exists:incoming_letters,id',
            'recipient' => 'required|string',
            'date_sent' => 'required|date',
            'letter_type_id' => 'required|exists:letter_type,id',
            'subject' => 'required|string',
            'content' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if (empty($validated['category'])) {
            $validated['category'] = !empty($validated['incoming_letter_id']) ? 'balasan' : 'umum';
        }

        // Generate nomor surat otomatis berdasarkan urutan sebelumnya
        $now = \Carbon\Carbon::parse($validated['date_sent']);
        $year = $now->year;
        $month = $now->month;
        $romanMonth = $this->getRomanMonth($month);
        
        $letterType = LetterType::find($validated['letter_type_id']);
        $kodeSurat = $letterType->letter_code;

        $nextSeq = $this->getNextSequenceNumber($kodeSurat, $year);
        $noUrut = str_pad($nextSeq, 2, '0', STR_PAD_LEFT);
        
        $companyCode = env('COMPANY_CODE', 'TAP');
        $letterNumber = "{$noUrut}/{$kodeSurat}/{$companyCode}/{$romanMonth}/{$year}";

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('outgoing_letters', 'public');
        }

        // Cek dan ganti placeholder [NOMOR_SURAT] di content
        $validated['content'] = str_replace('[NOMOR_SURAT]', $letterNumber, $validated['content']);

        $outgoingLetter = OutgoingLetter::create([
            'letter_number' => $letterNumber,
            'category'      => $validated['category'] ?? 'umum',
            'incoming_letter_id' => $validated['incoming_letter_id'] ?? null,
            'date_sent' => $validated['date_sent'],
            'letter_type_id' => $validated['letter_type_id'],
            'creator_id' => auth()->id(),
            'recipient' => $validated['recipient'],
            'subject' => $validated['subject'],
            'content' => $validated['content'],
            'file_path' => $validated['file_path'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('outgoing-letters.index')->with('success', "Surat Keluar berhasil dibuat dengan nomor: {$letterNumber}");
    }

    public function show(OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load(['letterType', 'creator', 'incomingLetter']);
        return view('admin.outgoing_letters.show', compact('outgoingLetter'));
    }

    public function edit(OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return redirect()->route('outgoing-letters.index')->with('error', 'Hanya surat berstatus pending yang dapat diubah.');
        }

        $letterTypes = LetterType::all();
        $incomingLetters = \App\Models\IncomingLetter::orderByDesc('date_received')->get();
        return view('admin.outgoing_letters.edit', compact('outgoingLetter', 'letterTypes', 'incomingLetters'));
    }

    public function update(Request $request, OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return redirect()->route('outgoing-letters.index')->with('error', 'Hanya surat berstatus pending yang dapat diubah.');
        }

        $validated = $request->validate([
            'category' => 'nullable|in:umum,balasan',
            'incoming_letter_id' => 'nullable|exists:incoming_letters,id',
            'recipient' => 'required|string',
            'date_sent' => 'required|date',
            'letter_type_id' => 'required|exists:letter_type,id',
            'subject' => 'required|string',
            'content' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if (empty($validated['category'])) {
            $validated['category'] = !empty($validated['incoming_letter_id']) ? 'balasan' : 'umum';
        }

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

    public function deliver(Request $request, OutgoingLetter $outgoingLetter)
    {
        if (!in_array($outgoingLetter->status, ['acc', 'delivered'])) {
            return back()->with('error', 'Hanya surat yang sudah disetujui (ACC) yang dapat diproses untuk dikirim (Delivery).');
        }

        $validated = $request->validate([
            'delivery_method' => 'required|string|max:100',
            'delivery_note'   => 'nullable|string|max:500',
        ]);

        $outgoingLetter->update([
            'status'          => 'delivered',
            'delivery_method' => $validated['delivery_method'],
            'delivery_note'   => $validated['delivery_note'],
            'delivered_at'    => now(),
        ]);

        return redirect()->route('outgoing-letters.index')->with('success', "Surat No. {$outgoingLetter->letter_number} berhasil dikirim (Delivered)!");
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
