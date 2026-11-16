<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            if (!Schema::hasColumn('otps', 'kode')) {
                $table->string('kode', 6)->nullable()->after('admin_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('otps', function (Blueprint $table) {
            if (Schema::hasColumn('otps', 'kode')) {
                $table->dropColumn('kode');
            }
        });
    }
};
