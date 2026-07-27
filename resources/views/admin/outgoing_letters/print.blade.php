<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keluar - {{ $outgoingLetter->letter_number }}</title>
    <style>
        @page {
            margin-top: 1cm;
            margin-left: 2.5cm;
            margin-right: 2.5cm;
            margin-bottom: 2cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.15;
            margin: 0;
            padding: 0;
        }
        
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .kop-surat h1 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        .kop-surat p {
            font-size: 10pt;
            margin: 5px 0 0 0;
        }
        
        .meta-surat {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        
        .meta-surat td {
            vertical-align: top;
            padding: 2px 0;
        }

        .tanggal-surat {
            text-align: right;
            margin-bottom: 10px;
        }
        
        .isi-surat {
            text-align: justify;
            margin-bottom: 30px;
        }

        .ttd-box {
            width: 250px;
            float: right;
            text-align: center;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        
        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 70px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

@php
    $typeName = $outgoingLetter->letterType->type_name ?? '';
    $typeNameLower = strtolower($typeName);
    
    // Deteksi kategori Surat Naskah Khusus (SK, Keterangan, Tugas, Keputusan, Peringatan, dll)
    $isNaskahKhusus = false;
    $keywords = ['keterangan', 'tugas', 'keputusan', 'sk', 'perintah', 'kuasa', 'rekomendasi', 'peringatan'];
    foreach ($keywords as $kw) {
        if (str_contains($typeNameLower, $kw)) {
            $isNaskahKhusus = true;
            break;
        }
    }

    $content = $outgoingLetter->content;

    // Untuk surat biasa (Korespondensi: Edaran, Undangan, dll), 
    // bersihkan tabel meta (Nomor/Perihal/Lampiran) bawaan template editor jika ada agar tidak ganda / tertimpa.
    if (!$isNaskahKhusus) {
        // Hapus tabel mceNonEditable / meta bawaan editor jika ada di awal teks
        $content = preg_replace('/<table[^>]*mceNonEditable[^>]*>.*?<\/table>/is', '', $content);
        $content = preg_replace('/^(\s*<br\s*\/?>\s*)*<table[^>]*>.*?Nomor.*?Perihal.*?<\/table>/is', '', $content);
    }
@endphp

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <h1>THE PRIME TEKHNOLOGI</h1>
        <p>Jl. Veteran No. 123, Kota Bogor, Jawa Barat 16124<br>
        Email: info@theprimetekhnologi.com | Telp: (0251) 123456</p>
    </div>

    @if(!$isNaskahKhusus)
        <!-- TANGGAL SURAT -->
        <div class="tanggal-surat">
            Bogor, {{ \Carbon\Carbon::parse($outgoingLetter->date_sent)->translatedFormat('d F Y') }}
        </div>

        <!-- META SURAT (3 POIN: NOMOR, LAMPIRAN, PERIHAL) -->
        <table class="meta-surat">
            <tr>
                <td width="70">Nomor</td>
                <td width="10">:</td>
                <td>{{ $outgoingLetter->letter_number }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td><strong>{{ $outgoingLetter->subject }}</strong></td>
            </tr>
        </table>

        <!-- TUJUAN -->
        <div style="margin-bottom: 20px;">
            Yth. <strong>{{ $outgoingLetter->recipient }}</strong><br>
            di Tempat
        </div>
    @endif

    <!-- ISI SURAT -->
    <div class="isi-surat">
        {!! $content !!}
    </div>

    <!-- KOLOM CAP STEMPEL & TANDA TANGAN -->
    <table style="width: 100%; margin-top: 40px; page-break-inside: avoid; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: center;">
                <p style="margin: 0; font-weight: bold; color: #444;">Cap Stempel Perusahaan,</p>
                <div style="margin: 12px auto; height: 85px; width: 150px; display: flex; align-items: center; justify-content: center;">
                    @if(in_array($outgoingLetter->status, ['acc', 'delivered']))
                        <!-- Cap Stempel Digital Resmi -->
                        <div style="border: 2.5px solid #0044BB; border-radius: 50%; width: 80px; height: 80px; margin: 0 auto; line-height: 1.15; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #0044BB; font-family: Arial, sans-serif; font-weight: bold; font-size: 7.5pt; text-align: center; padding: 4px; box-sizing: border-box; transform: rotate(-6deg); box-shadow: inset 0 0 0 1px #0044BB;">
                            THE PRIME<br><span style="font-size: 6.5pt; color: #008037;">★ SEAL ★</span><br>TEKHNOLOGI
                        </div>
                    @else
                        <!-- Kolom Kosong Stempel -->
                        <div style="border: 1.5px dotted #999; width: 130px; height: 70px; line-height: 70px; color: #777; font-size: 9.5pt; margin: 0 auto; text-align: center; font-family: Arial, sans-serif;">
                            [ Kolom Cap Stempel ]
                        </div>
                    @endif
                </div>
                <p style="margin: 0; font-size: 9pt; color: #666; font-style: italic;">Otorisasi PT The Prime Tekhnologi</p>
            </td>
            <td style="width: 50%; vertical-align: top; text-align: center;">
                <p style="margin: 0; font-weight: bold;">Pimpinan / Chief Executive Officer,</p>
                
                <div style="margin: 12px auto; height: 85px; display: flex; align-items: center; justify-content: center;">
                    @if(in_array($outgoingLetter->status, ['acc', 'delivered']))
                        <!-- TTD Digital Resmi -->
                        <div style="border: 2px solid #008037; padding: 8px 14px; border-radius: 6px; background-color: #f6fff9; display: inline-block; text-align: center; max-width: 210px;">
                            <div style="font-size: 11px; font-weight: bold; color: #008037; letter-spacing: 0.5px;">
                                [✔] SIGNED & APPROVED
                            </div>
                            <div style="font-size: 9px; color: #333; margin-top: 3px; font-weight: bold;">
                                By: Chief Executive Officer
                            </div>
                            @if($outgoingLetter->approved_at)
                            <div style="font-size: 8px; color: #555; margin-top: 3px;">
                                Tgl: {{ \Carbon\Carbon::parse($outgoingLetter->approved_at)->format('d/m/Y - H:i') }} WIB
                            </div>
                            @endif
                        </div>
                    @else
                        <!-- Kolom Kosong Tanda Tangan -->
                        <div style="border: 1.5px dotted #999; width: 160px; height: 70px; line-height: 70px; color: #777; font-size: 9.5pt; margin: 0 auto; text-align: center; font-family: Arial, sans-serif;">
                            [ Kolom Tanda Tangan ]
                        </div>
                    @endif
                </div>
                
                <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{ optional($outgoingLetter->creator)->name ?? 'Chief Executive Officer' }}</p>
                <p style="margin: 3px 0 0 0; font-size: 10pt;">NIP. {{ optional($outgoingLetter->creator)->nip ?? '..................................' }}</p>
            </td>
        </tr>
    </table>

</body>
</html>







