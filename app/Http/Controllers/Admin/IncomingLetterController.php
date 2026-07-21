<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class IncomingLetterController extends Controller
{
    public function extractOcr(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        try {
            $file = $request->file('file');
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();
            
            // Clean up common PDF parsing artifacts like stray '<' and '>' characters
            $text = str_replace(['<', '>'], '', $text);

            $data = [
                'letter_number' => '',
                'sender' => '',
                'subject' => '',
                'date_received' => date('Y-m-d')
            ];

            $lines = explode("\n", $text);
            // Filter empty lines
            $lines = array_values(array_filter(array_map('trim', $lines)));


            // ── 1. Extract Nomor Surat ──
            // Look for lines that strictly match "Nomor : xxx" or "No. : xxx"
            foreach ($lines as $i => $line) {
                if (preg_match('/^(?:nomor|no\.?)\s*[:\.]\s*(.+)/i', $line, $m)) {
                    $candidate = trim($m[1]);
                    // Must contain a slash or dash (typical letter number format)
                    if (preg_match('/[\\/\-]/', $candidate)) {
                        $data['letter_number'] = $candidate;
                        break;
                    }
                }
            }

            // ── 2. Extract Perihal / Subject ──
            $subjectFound = false;
            foreach ($lines as $i => $line) {
                if (preg_match('/^(?:perihal|hal)\s*[:\.]\s*(.*)/i', $line, $m)) {
                    $subject = trim($m[1]);
                    // Subject may continue on the next line(s) if the current line is short
                    if (strlen($subject) < 10 && isset($lines[$i + 1])) {
                        $subject .= ' ' . trim($lines[$i + 1]);
                    }
                    $data['subject'] = trim($subject);
                    $subjectFound = true;
                    break;
                }
            }

            // Fallback: look for common document titles
            if (!$subjectFound) {
                $titleKeywords = ['SURAT KETERANGAN', 'SURAT KEPUTUSAN', 'SURAT TUGAS', 'SURAT EDARAN', 'UNDANGAN', 'PEMBERITAHUAN', 'BERITA ACARA', 'MEMORANDUM', 'SURAT PERINTAH', 'SURAT PENGANTAR', 'SURAT PERNYATAAN', 'JUKNIS', 'PETUNJUK TEKNIS'];
                $searchLines = array_slice($lines, 0, 25);
                foreach ($searchLines as $line) {
                    $upperLine = mb_strtoupper($line);
                    foreach ($titleKeywords as $keyword) {
                        if (str_contains($upperLine, $keyword)) {
                            // Set subject and capitalize nicely
                            $data['subject'] = ucwords(strtolower(trim($line)));
                            $subjectFound = true;
                            break 2;
                        }
                    }
                }
            }

            // ── 3. Extract Pengirim / Sender ──
            // Strategy: look for "Dari:", or look for organization name in the header (first 15 lines)
            $senderFound = false;
            foreach ($lines as $line) {
                if (preg_match('/^(?:dari|pengirim)\s*[:\.]\s*(.+)/i', $line, $m)) {
                    $data['sender'] = trim($m[1]);
                    $senderFound = true;
                    break;
                }
            }

            if (!$senderFound) {
                // If "Dari:" is not found, we look at the first 5 lines for a Kop Surat (Header)
                // Kop Surat is typically ALL CAPS and at the very top.
                $headerLines = array_slice($lines, 0, 5);
                foreach ($headerLines as $line) {
                    $line = trim($line);
                    // If it's ALL CAPS, at least 10 chars, and not an address or date
                    if (mb_strtoupper($line) === $line && strlen($line) > 10) {
                        if (!preg_match('/(?:JALAN|JL\.|KODE POS|NOMOR|TANGGAL)/i', $line)) {
                            $data['sender'] = $line;
                            $senderFound = true;
                            break;
                        }
                    }
                }
            }

            // ── 4. Try to extract date from PDF ──
            // Only search in the top 15 lines to avoid picking up random dates in the letter body
            $dateLines = array_slice($lines, 0, 15);
            foreach ($dateLines as $line) {
                // Match Indonesian date patterns: "21 Juli 2026", usually near a city name or "Tanggal:"
                if (preg_match('/(\d{1,2})\s+(Januari|Februari|Maret|April|Mei|Juni|Juli|Agustus|September|Oktober|November|Desember)\s+(\d{4})/i', $line, $m)) {
                    $bulan = [
                        'januari'=>'01','februari'=>'02','maret'=>'03','april'=>'04',
                        'mei'=>'05','juni'=>'06','juli'=>'07','agustus'=>'08',
                        'september'=>'09','oktober'=>'10','november'=>'11','desember'=>'12'
                    ];
                    $bln = $bulan[strtolower($m[2])] ?? null;
                    if ($bln) {
                        $data['date_received'] = sprintf('%04d-%02d-%02d', $m[3], $bln, str_pad($m[1], 2, '0', STR_PAD_LEFT));
                        break;
                    }
                }
            }

            // ── 5. Auto-generate next sequential letter number ──
            $year = date('Y');
            $lastLetter = IncomingLetter::whereYear('created_at', $year)
                ->orderByDesc('id')
                ->first();

            $nextNum = 1;
            if ($lastLetter) {
                // Try to parse a sequence number from the existing letter_number
                if (preg_match('/^(\d+)/', $lastLetter->letter_number, $m)) {
                    $nextNum = (int) $m[1] + 1;
                } else {
                    $nextNum = IncomingLetter::whereYear('created_at', $year)->count() + 1;
                }
            }

            $data['next_letter_number'] = sprintf('%03d/SM/%s', $nextNum, $year);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membaca dokumen PDF: ' . $e->getMessage()], 422);
        }
    }

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
