<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('motor_id')
                ->constrained('motors')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('pelanggan_id')
                ->constrained('pelanggans')
                ->cascadeOnDelete();

            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali_rencana');
            $table->date('tanggal_kembali_real')->nullable();

            $table->decimal('harga_per_hari', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->decimal('denda', 10, 2)->nullable();

            $table->enum('status', ['aktif', 'selesai', 'batal']);
            $table->enum('status_pembayaran', ['belum', 'lunas']);
            $table->enum('metode_bayar', ['cash', 'transfer', 'qris'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
