<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetterType;

class DummyLetterTypeSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'letter_code' => 'SKK',
                'type_name' => 'Surat Keterangan Kerja',
                'template' => '
<div style="line-height: 1.6; font-size: 14px;">
    <p>Yang bertanda tangan di bawah ini:</p>
    <table style="width: 100%; margin-left: 20px; margin-bottom: 20px;">
        <tr><td style="width: 150px;">Nama</td><td>: HR Manager</td></tr>
        <tr><td>Jabatan</td><td>: Human Resources Director</td></tr>
        <tr><td>Perusahaan</td><td>: PT Ruang Administrasi Indonesia</td></tr>
    </table>
    
    <p>Menerangkan dengan sesungguhnya bahwa:</p>
    <table style="width: 100%; margin-left: 20px; margin-bottom: 20px;">
        <tr><td style="width: 150px;">Nama</td><td>: <strong>{nama_karyawan}</strong></td></tr>
        <tr><td>Nomor Induk Karyawan</td><td>: {nip}</td></tr>
        <tr><td>Jabatan</td><td>: {jabatan}</td></tr>
    </table>
    
    <p>Adalah benar merupakan karyawan di perusahaan kami sejak tanggal {tanggal_masuk} hingga saat surat ini dikeluarkan, dan yang bersangkutan telah menunjukkan kinerja dan kelakuan yang baik selama bekerja di perusahaan kami.</p>
    
    <p>Demikian surat keterangan kerja ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
</div>

<div style="margin-top: 50px; text-align: right;">
    <p>Jakarta, {tanggal_hari_ini}</p>
    <p style="margin-bottom: 80px;">Hormat Kami,</p>
    <p><strong>HR Manager</strong></p>
    <p>Human Resources Director</p>
</div>',
            ],
            [
                'letter_code' => 'SP1',
                'type_name' => 'Surat Peringatan (SP 1)',
                'template' => '
<div style="line-height: 1.6; font-size: 14px;">
    <p>Surat Peringatan ini diberikan kepada:</p>
    <table style="width: 100%; margin-left: 20px; margin-bottom: 20px;">
        <tr><td style="width: 150px;">Nama</td><td>: <strong>{nama_karyawan}</strong></td></tr>
        <tr><td>Jabatan</td><td>: {jabatan}</td></tr>
        <tr><td>Departemen</td><td>: {departemen}</td></tr>
    </table>
    
    <p>Sebagai bentuk pembinaan dan peringatan atas pelanggaran kedisiplinan yang telah dilakukan oleh yang bersangkutan, yaitu:</p>
    <div style="padding: 15px; background-color: #fef2f2; border-left: 4px solid #ef4444; margin: 15px 0;">
        <p style="margin: 0;"><em>{deskripsi_pelanggaran}</em></p>
    </div>
    
    <p>Tindakan tersebut merupakan pelanggaran terhadap Peraturan Perusahaan Pasal {pasal_pelanggaran}. Kami berharap Saudara/i dapat memperbaiki kinerja dan kedisiplinan ke depannya. Surat peringatan ini berlaku selama 3 (tiga) bulan sejak diterbitkan.</p>
    
    <p>Demikian Surat Peringatan ini dibuat agar menjadi perhatian.</p>
</div>

<div style="margin-top: 50px; display: flex; justify-content: space-between;">
    <div style="text-align: center;">
        <p>Menerima,</p>
        <p style="margin-bottom: 80px;"><br></p>
        <p><strong>{nama_karyawan}</strong></p>
    </div>
    <div style="text-align: center;">
        <p>Jakarta, {tanggal_hari_ini}</p>
        <p style="margin-bottom: 80px;">Mengetahui,</p>
        <p><strong>HR Manager</strong></p>
    </div>
</div>',
            ],
            [
                'letter_code' => 'SU',
                'type_name' => 'Surat Undangan Rapat',
                'template' => '
<div style="line-height: 1.6; font-size: 14px;">
    <p>Dengan hormat,</p>
    <p>Sehubungan dengan pelaksanaan agenda {topik_rapat}, kami mengundang Bapak/Ibu untuk hadir dalam rapat yang akan diselenggarakan pada:</p>
    
    <table style="width: 100%; margin-left: 30px; margin-bottom: 25px; margin-top: 15px;">
        <tr><td style="width: 130px;">Hari/Tanggal</td><td>: {hari_tanggal}</td></tr>
        <tr><td>Waktu</td><td>: {waktu} WIB s.d. Selesai</td></tr>
        <tr><td>Tempat</td><td>: {ruangan}</td></tr>
        <tr><td style="vertical-align: top;">Agenda</td><td>: {agenda_detail}</td></tr>
    </table>
    
    <p>Mengingat pentingnya acara ini, kami memohon kehadiran Bapak/Ibu tepat pada waktunya. Demikian undangan ini kami sampaikan, atas perhatian dan kerja samanya kami ucapkan terima kasih.</p>
</div>

<div style="margin-top: 60px; text-align: right; font-size: 14px;">
    <p style="margin-bottom: 5px;">Hormat kami,</p>
    <p style="margin-bottom: 90px;">Sekretaris Perusahaan</p>
    <p><strong>{nama_penandatangan}</strong></p>
</div>',
            ],
            [
                'letter_code' => 'SPK',
                'type_name' => 'Surat Perjanjian Kerjasama (MoU)',
                'template' => '
<div style="font-size: 14px; text-align: justify; line-height: 1.6;">
    <p>Pada hari ini, <strong>{hari_tanggal}</strong>, bertempat di <strong>{tempat_perjanjian}</strong>, yang bertanda tangan di bawah ini:</p>
    
    <div style="margin-left: 20px; margin-bottom: 25px;">
        <p style="margin-bottom: 5px;"><strong>I. PIHAK PERTAMA</strong></p>
        <table style="width: 100%; margin-left: 15px;">
            <tr><td style="width: 180px;">Nama / Instansi</td><td>: <strong>PT Ruang Administrasi Indonesia</strong></td></tr>
            <tr><td>Diwakili Oleh</td><td>: {nama_wakil_pertama}</td></tr>
            <tr><td>Jabatan</td><td>: {jabatan_wakil_pertama}</td></tr>
            <tr><td style="vertical-align: top;">Alamat</td><td>: Jl. Jendral Sudirman No. 123, Jakarta Pusat</td></tr>
        </table>
    </div>
    
    <div style="margin-left: 20px; margin-bottom: 30px;">
        <p style="margin-bottom: 5px;"><strong>II. PIHAK KEDUA</strong></p>
        <table style="width: 100%; margin-left: 15px;">
            <tr><td style="width: 180px;">Nama / Instansi</td><td>: <strong>{nama_instansi_kedua}</strong></td></tr>
            <tr><td>Diwakili Oleh</td><td>: {nama_wakil_kedua}</td></tr>
            <tr><td>Jabatan</td><td>: {jabatan_wakil_kedua}</td></tr>
            <tr><td style="vertical-align: top;">Alamat</td><td>: {alamat_instansi_kedua}</td></tr>
        </table>
    </div>
    
    <p>PIHAK PERTAMA dan PIHAK KEDUA secara bersama-sama selanjutnya disebut sebagai <strong>PARA PIHAK</strong>. PARA PIHAK sepakat untuk mengadakan Perjanjian Kerjasama (MoU) dalam bidang <strong>{bidang_kerjasama}</strong> dengan ketentuan dan syarat-syarat sebagai berikut:</p>
    
    <h3 style="text-align: center; margin-top: 30px; font-size: 15px; text-decoration: underline;">PASAL 1 : MAKSUD DAN TUJUAN</h3>
    <p>Perjanjian ini dimaksudkan sebagai landasan hukum pelaksanaan kerjasama antara PARA PIHAK dengan tujuan untuk saling memberikan manfaat dalam pengembangan <em>{tujuan_kerjasama_detail}</em> berdasarkan prinsip saling menguntungkan (<em>Mutual Benefit</em>).</p>
    
    <h3 style="text-align: center; margin-top: 25px; font-size: 15px; text-decoration: underline;">PASAL 2 : RUANG LINGKUP</h3>
    <p>Ruang lingkup kerjasama ini meliputi namun tidak terbatas pada:</p>
    <ol style="margin-top: 5px;">
        <li>Pelaksanaan program <em>{program_1}</em>;</li>
        <li>Penyediaan sumber daya terkait <em>{program_2}</em>;</li>
        <li>{program_3_opsional}.</li>
    </ol>
    
    <h3 style="text-align: center; margin-top: 25px; font-size: 15px; text-decoration: underline;">PASAL 3 : JANGKA WAKTU</h3>
    <p>Perjanjian ini berlaku terhitung sejak tanggal ditandatanganinya Surat Perjanjian Kerjasama ini dan akan dievaluasi serta berlaku selama <strong>{jangka_waktu}</strong> tahun, serta dapat diperpanjang atas kesepakatan tertulis PARA PIHAK.</p>
    
    <h3 style="text-align: center; margin-top: 25px; font-size: 15px; text-decoration: underline;">PASAL 4 : PENUTUP</h3>
    <p>Demikian Surat Perjanjian Kerjasama ini dibuat dalam rangkap 2 (dua), bermeterai cukup, dan masing-masing mempunyai kekuatan hukum yang sama bagi PARA PIHAK.</p>
</div>

<table style="width: 100%; margin-top: 60px; font-size: 14px; text-align: center; border-collapse: collapse;">
    <tr>
        <td style="width: 50%; vertical-align: top;">
            <p style="margin-bottom: 5px;"><strong>PIHAK PERTAMA</strong></p>
            <p style="margin-bottom: 90px; font-size: 13px;">PT Ruang Administrasi Indonesia</p>
            <p style="margin-bottom: 0;"><strong>{nama_wakil_pertama}</strong></p>
            <div style="margin: 0 auto; width: 80%; border-top: 1px solid #333; padding-top: 5px; font-size: 13px;">{jabatan_wakil_pertama}</div>
        </td>
        <td style="width: 50%; vertical-align: top;">
            <p style="margin-bottom: 5px;"><strong>PIHAK KEDUA</strong></p>
            <p style="margin-bottom: 90px; font-size: 13px;">{nama_instansi_kedua}</p>
            <p style="margin-bottom: 0;"><strong>{nama_wakil_kedua}</strong></p>
            <div style="margin: 0 auto; width: 80%; border-top: 1px solid #333; padding-top: 5px; font-size: 13px;">{jabatan_wakil_kedua}</div>
        </td>
    </tr>
</table>

<div style="margin-top: 50px; text-align: center; font-size: 14px;">
    <p style="margin-bottom: 80px;"><strong>SAKSI - SAKSI</strong></p>
    <table style="width: 100%; text-align: center; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p style="margin-bottom: 5px;"><strong>{saksi_pertama}</strong></p>
                <p style="font-size: 12px; margin-top: 0;">Saksi Pihak Pertama</p>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <p style="margin-bottom: 5px;"><strong>{saksi_kedua}</strong></p>
                <p style="font-size: 12px; margin-top: 0;">Saksi Pihak Kedua</p>
            </td>
        </tr>
    </table>
</div>',
            ],
        ];

        foreach ($templates as $template) {
            LetterType::updateOrCreate(['letter_code' => $template['letter_code']], $template);
        }
    }
}
