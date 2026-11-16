<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanan_berkas', function (Blueprint $table) {
            $table->string('fotokopi', 100)->nullable()->after('teks');
            $table->boolean('wajib_asli')->default(true)->after('fotokopi');
            $table->string('keterangan', 255)->nullable()->after('wajib_asli');
        });

        Schema::table('layanan_langkah', function (Blueprint $table) {
            $table->string('kode_loket', 50)->nullable()->after('teks');
            $table->text('keterangan')->nullable()->after('kode_loket');
        });
    }

    public function down(): void
    {
        Schema::table('layanan_berkas', function (Blueprint $table) {
            $table->dropColumn(['fotokopi', 'wajib_asli', 'keterangan']);
        });

        Schema::table('layanan_langkah', function (Blueprint $table) {
            $table->dropColumn(['kode_loket', 'keterangan']);
        });
    }
};

