# Dokumentasi Admin - Koperasi Simpan Pinjam

## Login

Buka aplikasi di browser, klik **Login**, masukkan:
- **Email:** `admin@koperasi.com`
- **Password:** `password`

---

## 1. Dashboard

Halaman utama admin menampilkan ringkasan data koperasi berupa 4 kartu statistik:
- **Total Anggota** — jumlah seluruh anggota terdaftar
- **Total Saldo Simpanan** — akumulasi saldo simpanan seluruh anggota
- **Total Pinjaman Aktif** — total pinjaman yang masih berjalan
- **Pinjaman Menunggu** — jumlah pengajuan pinjaman yang belum diproses

---

## 2. Kelola Anggota

**Menu:** Anggota

Menampilkan daftar seluruh anggota koperasi dalam tabel.

| Aksi | Deskripsi |
|------|-----------|
| Detail | Lihat profil, simpanan, pinjaman, dan SHU anggota |

---

## 3. Jenis Pinjaman

**Menu:** Jenis Pinjaman

Mengelola produk pinjaman yang ditawarkan ke anggota.

### Fitur:
- **Tambah Jenis Pinjaman** — buat produk baru dengan parameter:
  - Nama
  - Bunga (%)
  - Minimal / Maksimal pinjaman
  - Minimal / Maksimal tenor (bulan)
  - Status aktif/non-aktif
- **Edit** — ubah parameter produk
- **Non-aktifkan** — menonaktifkan produk (tidak bisa diajukan anggota)

---

## 4. Kelola Simpanan

**Menu:** Simpanan

Menampilkan daftar seluruh rekening simpanan milik anggota. Terdapat 3 jenis simpanan:
- **Wajib** — simpanan rutin yang ditentukan koperasi
- **Manasuka** — simpanan sukarela kapan saja
- **Sukarela** — simpanan dengan akumulasi tertentu

Klik **Detail** pada rekening untuk melihat riwayat transaksi (setoran & penarikan).

---

## 5. Kelola Pinjaman

**Menu:** Pinjaman

Menampilkan daftar seluruh pengajuan pinjaman.

### Status Pinjaman:
| Status | Keterangan |
|--------|------------|
| Pending | Menunggu persetujuan admin |
| Approved | Disetujui, menunggu pencairan |
| Rejected | Ditolak |
| Disbursed | Sudah dicairkan, dalam masa angsuran |
| Completed | Lunas |
| Defaulted | Macet |

### Alur Pemrosesan Pinjaman:

1. **Lihat Detail** — klik tombol **Lihat** untuk melihat:
   - Informasi peminjam
   - Detail pinjaman (jumlah, bunga, tenor)
   - Tabel angsuran (amortisasi) — cicilan pokok + bunga per bulan
2. **Approve** — menyetujui pengajuan (status berubah ke `approved`)
3. **Disburse** — mencairkan dana (status berubah ke `disbursed`)
4. **Reject** — menolak pengajuan
5. **Hapus** — soft delete pinjaman

### Mencatat Pembayaran Angsuran:

Pada halaman detail pinjaman yang sudah **disbursed**, admin dapat mencatat pembayaran angsuran:
- Masukkan jumlah angsuran yang dibayar
- Sistem otomatis memisahkan pembayaran menjadi **pokok** dan **bunga**
- Saldo pinjaman akan berkurang sesuai sisa pokok
- Riwayat pembayaran tercatat di tabel bawah

---

## 6. Laporan & Rekapitulasi

**Menu:** Laporan

Terdapat 5 jenis laporan:

### a. Laporan Anggota
Data seluruh anggota lengkap dengan total simpanan dan jumlah pinjaman aktif per anggota.

### b. Laporan Transaksi Simpanan
Riwayat transaksi simpanan yang bisa difilter berdasarkan:
- Rentang tanggal
- Anggota
- Jenis transaksi (setoran/penarikan)

Menampilkan total setoran dan total penarikan.

### c. Laporan Pinjaman
Data pengajuan pinjaman yang bisa difilter:
- Rentang tanggal
- Status pinjaman
- Anggota

Menampilkan total pinjaman dicairkan, total pembayaran, dan total outstanding.

### d. Laporan Keuangan
Rekapitulasi keuangan koperasi:
- Total simpanan
- Total pinjaman aktif
- Total pembayaran angsuran terkumpul
- Saldo bersih

### e. Laporan Laba Rugi (P&L)
Laporan laba rugi periode tertentu:
- **Pendapatan Bunga** — bunga dari pinjaman
- **Pokok Terkumpul** — total pembayaran pokok
- **Beban Operasional** — pengeluaran koperasi
- **Laba/Rugi Bersih**

---

## 7. Beban Operasional

**Menu:** Beban

Mencatat pengeluaran operasional koperasi.

### Fitur:
- **Tambah Beban** — catat pengeluaran (deskripsi, jumlah, tanggal)
- **Hapus** — hapus catatan beban

Data beban digunakan dalam laporan Laba Rugi (P&L).

---

## 8. SHU (Sisa Hasil Usaha)

**Menu:** SHU

Mengelola pembagian SHU kepada anggota.

### Alur SHU:

1. **Buat Periode SHU** — tentukan:
   - Nama periode (contoh: "SHU 2025")
   - Rentang tanggal
   - Total laba periode
   - Persentase jasa anggota
   - Bobot simpanan
   - Bobot pinjaman
2. **Hitung SHU** — sistem akan menghitung pembagian SHU per anggota berdasarkan:
   - **Bobot Simpanan** — proporsi saldo simpanan anggota terhadap total simpanan
   - **Bobot Pinjaman** — proporsi bunga dibayar anggota terhadap total bunga
3. **Lihat Detail** — rekap SHU per anggota:
   - Saldo simpanan
   - Bunga dibayar
   - Persentase jasa simpanan & pinjaman
   - Jumlah SHU diterima
4. **Hapus** — hapus periode SHU

---

## 9. Profil

**Menu:** Profil (pojok kanan atas)

Mengubah data diri admin:
- Nama, email, telepon, alamat
- Ganti password (memerlukan password saat ini)

---

## Catatan Penting

- Semua data bersifat real-time dan langsung tersimpan ke database
- Data yang sudah dihapus pada pinjaman bersifat soft delete (masih bisa dipulihkan di database)
- SHU yang sudah dihitung bisa dihapus dan dihitung ulang jika ada perubahan data
