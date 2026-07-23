<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keluar - {{ $outgoingLetter->letter_number }}</title>
    <style>
        @page {
            margin-top: 3cm;
            margin-left: 3cm;
            margin-right: 2.5cm;
            margin-bottom: 2.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 25px;
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
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        
        .meta-surat td {
            vertical-align: top;
            padding: 2px 0;
        }

        .tanggal-surat {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .isi-surat {
            text-align: justify;
            margin-bottom: 30px;
            min-height: 250px;
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

    <!-- TANDA TANGAN -->
    <div class="ttd-box">
        <p style="margin-bottom: 0;">Pimpinan / Manager,</p>
        
        <p class="ttd-nama">{{ optional($outgoingLetter->creator)->name ?? 'THE PRIME TEKHNOLOGI' }}</p>
        <p style="margin: 0;">NIP. {{ optional($outgoingLetter->creator)->nip ?? '.........................' }}</p>
    </div>

</body>
</html>







