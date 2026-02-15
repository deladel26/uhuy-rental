<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')
                ->constrained('pelanggans')
                ->cascadeOnDelete();
            $table->enum('jenis_dokumen', ['KTP', 'SIM', 'LAINNYA']);
            $table->string('file_path');
            $table->dateTime('uploaded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pelanggan');
    }
};
