<?php

namespace Database\Seeders;

use App\Models\Seats;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seat;
use App\Models\Showtimes;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $showtimes = Showtimes::all();
        foreach ($showtimes as $showtime) {
            for ($i = 1; $i <= 20; $i++) {
                Seats::create([
                    'showtimes_id' => $showtime->id,
                    'nomor_kursi' => 'A' . $i,
                    'status' => 'kosong',
                ]);
            }
        }
    }
}
