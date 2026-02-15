<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas'])->after('password');
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif')->after('role');

            // opsional: hapus email_verified_at jika memang tidak dipakai
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};
