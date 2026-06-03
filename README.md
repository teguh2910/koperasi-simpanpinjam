# Koperasi Simpan Pinjam

Aplikasi Koperasi Simpan Pinjam dengan Laravel 11, Docker, Bootstrap, dan PostgreSQL.

## Requirements
- Docker & Docker Compose
- Git

## Installation

```bash
# Clone repository
git clone <repo-url>
cd koperasi-simpanpinjam

# Copy environment file
cp .env.example .env

# Start Docker containers
docker-compose up -d

# Generate application key
docker-compose exec app php artisan key:generate

# Run migrations
docker-compose exec app php artisan migrate

# Seed database (optional)
docker-compose exec app php artisan db:seed
```

## Access

- Website: http://localhost:8080
- pgAdmin: http://localhost:5050 (admin@admin.com / admin)

## Login Default

Admin: admin@koperasi.com / password
Member: Register melalui halaman register

## Fitur

### Admin
- Dashboard statistik
- Kelola anggota
- Kelola simpanan
- Kelola pinjaman (approve/reject/disburse)

### Member
- Dashboard saldo
- Kelola simpanan (wajib, manasuka, sukarela)
- Ajukan pinjaman
- Lihat riwayat pinjaman