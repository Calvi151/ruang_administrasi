# Prompt AI Agent Khusus Backend (Laravel 11)

Karena Anda hanya bertanggung jawab pada bagian **Backend**, gunakan prompt yang sangat terfokus pada logika backend, routing, request validation, authentication (NIP), middleware, dan database operation berikut untuk diberikan ke AI Agent (seperti Cursor, Claude, dll.):

```text
Bertindaklah sebagai Backend Developer Laravel 11 Specialist. Saya sedang membangun sistem administrasi surat menyurat berbasis web. Tugas saya HANYA fokus pada pengembangan BACKEND (Controller, Middleware, Request Validation, DB Operations, Authentication, & Routing). Desain dan slicing Tailwind CSS akan dikerjakan oleh tim frontend secara terpisah.

Silakan buatkan seluruh logika backend yang aman, terstruktur, dan bersih untuk spesifikasi berikut:

---

### 1. SKEMA DATABASE & MODEL YANG SUDAH ADA
- Model 'User' (role: admin, ceo | login menggunakan kolom 'nip').
- Model 'Employee' (nip, name, email, photo, number) -> Hubungan 1:1 ke User via 'nip'.
- Model 'LetterType' (letter_code, type_name).
- Model 'IncomingLetter' (letter_number, date_received, sender, subject, file).
- Model 'OutgoingLetter' (letter_number, date_sent, letter_type_id, creator_id, recipient, subject, content, status: 'pending', 'acc', 'reject').

---

### 2. SISTEM AUTENTIKASI (NIP-BASED LOGIN)
- Buat logic Autentikasi menggunakan 'nip' dan 'password' (Gunakan Laravel Fortify, Breeze, atau manual Auth Attempt).
- Buat LoginController yang melakukan autentikasi, melakukan session regeneration, dan mengembalikan redirect:
  * Jika Role 'admin' -> Redirect ke '/admin/dashboard'
  * Jika Role 'ceo' -> Redirect ke '/ceo/dashboard'
- Buat LogoutController untuk menghapus session dan token secara aman.

---

### 3. MIDDLEWARE KEAMANAN (ROLE-BASED ACCESS CONTROL)
- Buat Middleware untuk memproteksi rute berdasarkan role:
  * 'RoleAdminMiddleware': Hanya mengizinkan user dengan role 'admin' untuk mengakses rute tertentu.
  * 'RoleCeoMiddleware': Hanya mengizinkan user dengan role 'ceo' untuk mengakses rute tertentu.
- Pastikan rute tamu (guest) dan rute yang butuh login terproteksi dengan baik menggunakan middleware bawaan Laravel 'auth'.

---

### 4. LOGIKA CONTROLLER ADMIN ('/admin/...')
Buat Controller dengan validasi input yang ketat (Form Request) untuk fungsionalitas berikut:
- **Dashboard Data**: Mengambil statistik ringkas (Total Surat Masuk, Total Surat Keluar, Surat Keluar berstatus ACC/Pending/Reject) untuk dioper ke view atau dikembalikan sebagai JSON.
- **IncomingLetterController (CRUD)**:
  * Index: List surat masuk (with pagination & search query filter).
  * Store: Validasi input + upload file dokumen fisik surat masuk ke storage lokal (PDF/Image) -> Simpan path di database.
  * Update: Update detail surat masuk (termasuk ganti file/opsional).
  * Destroy: Hapus data surat masuk beserta file fisiknya dari storage.
- **OutgoingLetterController (CRUD untuk Admin)**:
  * Index: Menampilkan semua surat keluar yang diajukan.
  * Store: Membuat draft surat keluar baru dengan status otomatis 'pending' (mewakili status penangguhan/menunggu persetujuan CEO).
  * Update: Admin HANYA boleh mengubah data surat keluar jika 'status' di database masih 'pending'. Jika sudah 'acc' atau 'reject', lemparkan HttpException 403 (Unauthorized).
  * Destroy: Admin HANYA boleh menghapus surat keluar yang berstatus 'pending'. Jika tidak, lemparkan error 403.
- **LetterTypeController & EmployeeController**:
  * Standar CRUD resource controller untuk master data.

---

### 5. LOGIKA CONTROLLER CEO ('/ceo/...')
Buat Controller untuk menangani hak akses CEO:
- **CEO Dashboard**: Mengambil statistik surat masuk dan daftar surat keluar berstatus 'pending' (antrean approval).
- **LetterApprovalController**:
  * Index: Menampilkan list surat keluar yang berstatus 'pending'.
  * Show: Menampilkan detail surat keluar tertentu untuk ditinjau oleh CEO.
  * Approve (Aksi ACC): Mengubah status surat keluar terkait dari 'pending' menjadi 'acc'.
  * Reject (Aksi Reject): Mengubah status surat keluar terkait dari 'pending' menjadi 'reject'.
- **Read-Only Access**: Buat method untuk menampilkan list Surat Masuk, Surat Keluar yang sudah selesai diproses (ACC/Reject), dan list Pegawai hanya untuk dibaca saja (read-only) tanpa fitur CRUD.

---

### 6. OUTPUT & ROUTING
- Susun rute secara rapi di file `routes/web.php` menggunakan Route Groups dan Middleware.
- Semua Controller harus mengembalikan data ke View dengan rapi (misalnya: `return view('admin.incoming.index', compact('letters'))`) ATAU return JSON response jika saya meminta untuk dikonversi menjadi REST API.
- Tulis kode PHP yang bersih dengan Type-Hinting, Exception Handling, dan return types yang jelas.
```
