<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('nama', 150);
            $table->text('deskripsi')->nullable();
            $table->foreignId('kategori_id')->constrained('kategori_layanan')->onDelete('restrict');
            $table->string('warna', 7)->default('#0D47A1');
            $table->boolean('terpublikasi')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
