<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->foreignId('showtimes_id')->constrained()->onDelete('cascade');
            $table->json('seats');
            $table->integer('total_price');

            // MIDTRANS RELATED
            $table->string('bookings_code')->unique();       // internal booking reference
            $table->string('order_id')->unique()->nullable(); // Midtrans order_id
            $table->string('payment_status')->default('pending'); // pending / success / failed
            $table->timestamp('paid_at')->nullable();       // waktu pembayaran sukses

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};