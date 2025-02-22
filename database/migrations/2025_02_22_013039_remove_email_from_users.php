<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan perubahan.
     */
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email'); // Hapus kolom email dari users
            $table->dropColumn('email_verified_at'); // Hapus email_verified_at jika ada
        });
    }

    /**
     * Kembalikan perubahan jika dibatalkan.
     */
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};