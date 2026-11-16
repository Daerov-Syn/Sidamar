<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_pemutihan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->date('mulai');
            $table->date('selesai');
            $table->enum('tipe_potongan', ['persen', 'tetap']);
            $table->decimal('nilai', 15, 2);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->index(['aktif', 'mulai', 'selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_pemutihan');
    }
};
