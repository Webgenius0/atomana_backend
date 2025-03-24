<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS user_y_t_c_views');
        DB::statement("
        CREATE VIEW user_y_t_c_views AS
        SELECT user_id, business_id, contract_year_start, current_year_start, years_worked
        FROM (
            SELECT
                p.user_id,
                bu.business_id,
                p.contract_year_start,
                TIMESTAMPDIFF(YEAR, p.contract_year_start, CURDATE()) -
                    CASE
                        WHEN CURDATE() < DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(p.contract_year_start), '-', DAY(p.contract_year_start))) THEN 1
                        ELSE 0
                    END AS years_worked,
                CASE
                    WHEN CURDATE() < DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(p.contract_year_start), '-', DAY(p.contract_year_start))) THEN
                        DATE(CONCAT(YEAR(CURDATE()) - 1, '-', MONTH(p.contract_year_start), '-', DAY(p.contract_year_start)))
                    ELSE
                        DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(p.contract_year_start), '-', DAY(p.contract_year_start)))
                END AS current_year_start
            FROM profiles p
            LEFT JOIN business_user bu ON p.user_id = bu.user_id
        ) AS ytc;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS user_y_t_c_views');

    }
};
