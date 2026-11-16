<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masukan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->nullable();
            $table->string('kontak', 150)->nullable();
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('isi');
            $table->enum('status', ['Baru', 'Ditinjau', 'Selesai'])->default('Baru');
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masukan');
    }
};
