<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('aksi', 50); // INSERT, UPDATE, DELETE
            $table->string('tabel', 100);
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->timestamp('waktu')->useCurrent();
            
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_log');
    }
};
