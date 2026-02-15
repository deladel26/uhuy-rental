<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor', 15)->unique();
            $table->string('merk', 50);
            $table->year('tahun')->nullable();
            $table->string('warna', 30)->nullable();
            $table->decimal('harga_sewa', 10, 2);
            $table->enum('status', ['tersedia', 'disewa', 'servis'])->default('tersedia');
            $table->string('kondisi', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
