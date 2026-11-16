<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aturan_denda', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('periode_min_bulan');
            $table->unsignedSmallInteger('periode_max_bulan');
            $table->enum('tipe', ['persen', 'tetap']); // percentage or fixed
            $table->decimal('nilai', 15, 2);
            $table->timestamps();

            $table->index(['periode_min_bulan', 'periode_max_bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan_denda');
    }
};
