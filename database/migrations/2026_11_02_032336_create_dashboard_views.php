<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_dashboard_ringkasan");
        DB::statement("
            CREATE VIEW v_dashboard_ringkasan AS
            SELECT 
                (SELECT COUNT(*) FROM layanan WHERE terpublikasi = 1) AS total_layanan,
                (SELECT COUNT(*) FROM masukan) AS total_masukan,
                (SELECT COUNT(*) FROM masukan WHERE status = 'Baru') AS masukan_baru,
                COALESCE((SELECT AVG(rating) FROM masukan), 0) AS rata_rating;
        ");

        DB::statement("DROP VIEW IF EXISTS v_status_masukan");
        DB::statement("
            CREATE VIEW v_status_masukan AS
            SELECT 
                status,
                COUNT(*) AS jumlah
            FROM masukan
            GROUP BY status;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_dashboard_ringkasan");
        DB::statement("DROP VIEW IF EXISTS v_status_masukan");
    }
};
