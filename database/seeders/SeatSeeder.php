<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Showtimes;
use App\Models\Seats;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder ini hanya untuk mengisi tabel 'seats'.
     */
    public function run(): void
    {
        // Kosongkan tabel seats terlebih dahulu untuk menghindari duplikasi
        DB::table('seats')->truncate();

        // 1. Ambil SEMUA showtimes yang sudah ada di database
        $showtimes = Showtimes::all();

        if ($showtimes->isEmpty()) {
            $this->command->info('Tidak ada data showtimes untuk diisi kursi. Silakan isi tabel showtimes terlebih dahulu.');
            return;
        }

        $this->command->info('Membuat kursi untuk ' . $showtimes->count() . ' jadwal tayang...');

        // 2. Loop untuk setiap showtime
        foreach ($showtimes as $showtime) {
            // 3. Buat 20 kursi (A1-D5) untuk setiap showtime tersebut
            $rows = ['A', 'B', 'C', 'D'];
            $cols = [1, 2, 3, 4, 5];

            foreach ($rows as $row) {
                foreach ($cols as $col) {
                    Seats::create([
                        'showtimes_id' => $showtime->id,
                        'nomor_kursi' => $row . $col,
                        'status' => 'kosong', // Status awal semua kursi kosong
                    ]);
                }
            }
        }

        $totalSeats = $showtimes->count() * 20;
        $this->command->info('Selesai! Sebanyak ' . $totalSeats . ' kursi berhasil dibuat.');
    }
}