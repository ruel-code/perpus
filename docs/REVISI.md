# Revisi & Fitur Baru — PerpusDigital

## A. Perubahan Database

### 1. Tabel `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `photo` | `string nullable` | Path foto profil user |

### 2. Tabel `books`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `price` | `decimal(12,2) nullable` | Harga buku untuk perhitungan denda rusak/hilang |

### 3. Tabel `fines`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `category` | `string default:'terlambat'` | Kategori denda: `terlambat`, `rusak`, `hilang`, atau kombinasi `terlambat+rusak` |

### 4. Tabel `loans`
| Perubahan | Detail |
|---|---|
| ENUM status | Ditambah `menunggu` dan `ditolak` → `enum('dipinjam','dikembalikan','terlambat','menunggu','ditolak')` |

---

## B. Perubahan Sistem Roles

**Sebelum:**
- `admin` — staff
- `petugas` — staff
- `mahasiswa` — user biasa

**Sesudah:**
- `admin` — staff/officer (menggabungkan admin + petugas)
- `user` — mahasiswa/anggota biasa

---

## C. Fitur Baru — User Role

### 1. Halaman Profil (`/profile`)
- View biodata (nama, email, NIM, telepon, prodi, alamat, role)
- Edit biodata (inline form)
- Upload foto profil (JPEG/PNG, max 2MB)
- Ganti password (dengan validasi password saat ini)

**API:**
- `GET /api/profile` — ambil profil sendiri
- `PUT /api/profile` — update biodata
- `PUT /api/profile/password` — ganti password
- `POST /api/profile/photo` — upload foto

### 2. Batalkan Peminjaman
- User bisa membatalkan peminjaman yang masih berstatus `menunggu`
- Stok buku dikembalikan otomatis

**API:**
- `PUT /api/loans/{loan}/cancel` — batalkan peminjaman

### 3. Baca E-book
- Tombol "Baca" pada buku yang memiliki file PDF
- Menampilkan PDF inline di browser
- Parameter `?download=1` untuk download file

**API:**
- `GET /api/books/{book}/ebook` — baca/download e-book

### 4. Detail Buku (Modal)
- Klik judul/cover buku di katalog → modal detail
- Informasi lengkap: judul, penulis, penerbit, ISBN, kategori, jenis, tahun, lokasi rak, stok, deskripsi
- Tombol aksi: Pinjam & Baca E-book

### 5. Pencarian Katalog
- Filter real-time berdasarkan judul, penulis, kategori

---

## D. Fitur Baru — Manajemen Denda

### 1. Kategori Denda
| Kondisi | Perhitungan |
|---|---|
| Terlambat | Rp 5.000/hari |
| Rusak | 50% dari harga buku |
| Hilang | 100% dari harga buku |
| Terlambat + Rusak | (hari × 5.000) + (harga × 50%) |

### 2. Alur Pengembalian (Admin)
- Saat admin klik "Kembalikan" → muncul 3 pilihan kondisi:
  - **Baik** — tidak ada denda tambahan
  - **Rusak** — denda 50% harga buku
  - **Hilang** — denda 100% harga buku, stok dikurangi (tidak ditambah)
- Catatan kondisi otomatis diisi berdasarkan pilihan
- Denda langsung tercatat jika buku terlambat DAN/ATAU rusak/hilang

---

## E. Dashboard — Redesain

### Perubahan Tampilan
- Header gradien ungu-merah dengan glassmorphism
- 3 stat cards besar (sebelumnya 6 card sempit):
  - Koleksi: total buku, tersedia, dipinjam
  - Pengguna: total anggota, admin, user
  - Transaksi: aktif, dikembalikan, menunggu
- Chart bar gradien (Chart.js 4)
- Welcome card dengan backdrop blur
- Akses Cepat: Cari Buku, Riwayat, Kelola Pinjam, Laporan
- Info denda (total unpaid)

---

## F. Perbaikan Bugs

| No | Bug | Penyebab | Fix |
|---|---|---|---|
| 1 | `Data truncated for column 'status'` | ENUM loans.status tidak punya `menunggu`/`ditolak` | Migration update ENUM |
| 2 | `after:today` gagal karena timezone | Server UTC, browser WIB | Ganti ke `after_or_equal:today` |
| 3 | Denda tidak terbuat untuk rusak/hilang | `$bookPrice = 0` → `$totalFine = 0` → skip | Kondisi diubah ke `!empty($fineCategories)` |
| 4 | Status salah `terlambat` padahal tidak telat | `now()` (08:07) > `00:00` karena ada jam | `startOfDay()` pada kedua tanggal |
| 5 | `price` tidak tersimpan | Tidak ada di rules `StoreBookRequest` & `UpdateBookRequest` | Tambah validasi `price` |

---

## G. Perubahan Routing

### Web Routes (`routes/web.php`)
```
GET  /           → landing page (baru)
GET  /login      → form login
GET  /register   → form register
GET  /profile    → halaman profil (baru)
```

### API Routes (`routes/api.php`) — Baru
```
GET    /api/profile              — profil sendiri
PUT    /api/profile              — update biodata
PUT    /api/profile/password     — ganti password
POST   /api/profile/photo        — upload foto
PUT    /api/loans/{loan}/cancel  — batalkan peminjaman (user)
GET    /api/books/{book}/ebook   — baca e-book
```

---

## H. Halaman Baru

| Halaman | Route | Untuk |
|---|---|---|
| Landing page | `/` | Publik (sebelum login) |
| Profil | `/profile` | Semua role |

## I. Halaman yang Diperbarui

| Halaman | Perubahan |
|---|---|
| Dashboard | Redesain total (header, card, chart, akses cepat) |
| Katalog Buku | Pencarian (judul, penulis, kategori), modal detail, tombol baca e-book |
| Peminjaman Saya | Tombol batalkan, cover buku, badge status, tampilan penulis |
| Manajemen Pinjam | Tampilan penulis di kolom buku, pilihan kondisi saat kembali |
| Manajemen Denda | Kolom kategori denda, avatar peminjam, badge status warna |
| Manajemen Buku | Input harga buku, kolom harga di tabel |
| Sidebar | Link profil di navbar (avatar), sidebar hanya menu utama |
