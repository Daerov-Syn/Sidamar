<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('warna', 7)->default('#3B82F6'); // hex color
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_layanan');
    }
};
