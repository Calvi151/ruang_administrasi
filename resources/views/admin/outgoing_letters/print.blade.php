<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keluar - {{ $outgoingLetter->letter_number }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 2cm 2.5cm; /* Margin standar surat resmi */
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
        }
        
        .kop-surat h2 {
            font-size: 14pt;
            margin: 0;
        }
        
        .kop-surat p {
            font-size: 10pt;
            margin: 5px 0 0 0;
        }
        
        .meta-surat {
            width: 100%;
            margin-bottom: 30px;
        }
        
        .meta-surat td {
            vertical-align: top;
        }

        .tanggal-surat {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .isi-surat {
            text-align: justify;
            margin-bottom: 40px;
            min-height: 300px; /* Memberi ruang untuk isi */
        }

        .ttd-box {
            width: 300px;
            float: right;
            text-align: center;
            margin-top: 50px;
        }
        
        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 80px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT (Silakan sesuaikan dengan identitas asli) -->
    <div class="kop-surat">
        <h2>YAYASAN PENDIDIKAN TARUNA ANDIGHA</h2>
        <h1>SMK TARUNA ANDIGHA</h1>
        <p>Jl. Veteran No. 123, Kota Bogor, Jawa Barat 16124<br>
        Email: info@smktarunaandigha.sch.id | Telp: (0251) 123456</p>
    </div>

    <!-- TANGGAL SURAT -->
    <div class="tanggal-surat">
        Bogor, {{ \Carbon\Carbon::parse($outgoingLetter->date_sent)->translatedFormat('d F Y') }}
    </div>

    <!-- META SURAT -->
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

    <!-- ISI SURAT -->
    <div class="isi-surat">
        {!! $outgoingLetter->content !!}
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd-box">
        <p style="margin-bottom: 0;">Kepala Sekolah,</p>
        
        <!-- Ruang untuk tanda tangan basah / cap -->
        
        <p class="ttd-nama">CEO / Kepala Sekolah</p>
        <p style="margin: 0;">NIP. .........................</p>
    </div>

</body>
</html>







