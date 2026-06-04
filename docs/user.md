# Dokumentasi Anggota - Koperasi Simpan Pinjam

## Pendaftaran & Login

### Daftar Akun Baru
1. Buka aplikasi, klik **Register**
2. Isi data diri:
   - Nama lengkap
   - Email
   - Nomor telepon
   - Alamat
   - Password
3. Klik **Register**
4. Anda akan otomatis login dan diarahkan ke dashboard anggota

### Login
1. Klik **Login**
2. Masukkan email dan password
3. Klik **Login**

---

## 1. Dashboard Anggota

Halaman utama setelah login menampilkan ringkasan:
- **Total Saldo Simpanan** — gabungan semua jenis simpanan
- **Sisa Pinjaman** — outstanding pinjaman aktif (jika ada)
- **Total SHU Diterima** — akumulasi SHU yang sudah dibagikan

Dilengkapi tabel ringkasan:
- 5 simpanan terakhir
- 5 pinjaman terakhir
- 5 SHU terakhir

---

## 2. Simpanan

**Menu:** Simpanan

Anda dapat memiliki 3 jenis simpanan:
| Jenis | Keterangan |
|-------|------------|
| **Wajib** | Simpanan rutin sesuai ketentuan koperasi |
| **Manasuka** | Simpanan sukarela yang bisa dilakukan kapan saja |
| **Sukarela** | Simpanan dengan akumulasi tertentu |

### Melihat Simpanan
Halaman Simpanan menampilkan daftar rekening simpanan Anda lengkap dengan saldo masing-masing.

### Melakukan Setoran
1. Klik **Setor Simpanan**
2. Pilih **Jenis Simpanan** (wajib/manasuka/sukarela)
3. Masukkan **Jumlah**
4. Klik **Simpan**
5. Saldo simpanan akan bertambah otomatis

---

## 3. Pinjaman

**Menu:** Pinjaman

### Mengajukan Pinjaman
1. Klik **Ajukan Pinjaman**
2. Pilih **Jenis Pinjaman** (produk pinjaman yang tersedia)
3. Masukkan **Jumlah pinjaman** (dalam range minimal-maksimal)
4. Pilih **Tenor** (lama angsuran dalam bulan, dalam range yang tersedia)
5. Sistem akan menampilkan:
   - Angsuran per bulan (pokok + bunga)
   - Total pembayaran
6. Klik **Ajukan**
7. Status pinjaman: **Menunggu** — selanjutnya akan diproses admin

### Status Pinjaman
| Status | Arti |
|--------|------|
| Menunggu | Pengajuan belum diproses admin |
| Disetujui | Disetujui, menunggu pencairan dana |
| Ditolak | Pengajuan ditolak |
| Dicairkan | Dana sudah cair, sedang dalam masa angsuran |
| Lunas | Semua angsuran sudah dibayar |

### Melihat Detail Pinjaman
Klik **Lihat** pada pinjaman untuk:
- Informasi detail pinjaman
- **Tabel Angsuran** — rincian cicilan per bulan:
  - Bulan ke-
  - Tanggal jatuh tempo
  - Jumlah angsuran
  - Porsi pokok
  - Porsi bunga
  - Sisa pinjaman
  - Status (lunas/belum)

---

## 4. SHU (Sisa Hasil Usaha)

**Menu:** SHU

Halaman ini menampilkan daftar SHU yang pernah dibagikan ke Anda dari setiap periode.

Informasi per periode:
- Nama periode SHU
- Tanggal periode
- Jumlah SHU yang diterima
- Detail perhitungan (bobot simpanan & pinjaman)

---

## 5. Profil

**Menu:** Profil (pojok kanan atas)

### Mengubah Data Diri
1. Edit field yang ingin diubah (nama, email, telepon, alamat)
2. Klik **Simpan**

### Ganti Password
1. Masukkan **Password Saat Ini**
2. Masukkan **Password Baru**
3. Konfirmasi **Password Baru**
4. Klik **Ganti Password**

---

## Catatan Penting

- Setoran simpanan langsung menambah saldo dan tercatat otomatis
- Pinjaman yang sudah diajukan tidak bisa diedit atau dibatalkan sendiri — hubungi admin jika ada perubahan
- Pembayaran angsuran dilakukan melalui admin koperasi
- Data profil dapat diubah kapan saja
- Password harus mengandung kombinasi huruf dan angka untuk keamanan
