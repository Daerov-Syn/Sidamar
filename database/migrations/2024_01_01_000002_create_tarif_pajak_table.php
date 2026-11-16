<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarif_pajak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_id')->constrained('jenis_kendaraan')->onDelete('cascade');
            $table->unsignedSmallInteger('tahun_min');
            $table->unsignedSmallInteger('tahun_max');
            $table->decimal('nilai_dasar', 15, 2);
            $table->decimal('tarif_persen', 5, 2); // e.g. 1.50 for 1.5%
            $table->timestamps();

            $table->index(['jenis_id', 'tahun_min', 'tahun_max']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarif_pajak');
    }
};
