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
        DB::statement('DROP VIEW IF EXISTs agent_earning_views');
        DB::statement("
        CREATE VIEW agent_earning_views AS
            SELECT
                sales_tracks.user_id,
                sales_tracks.business_id,
                COUNT(sales_tracks.id) AS sales_closed,
                profiles.contract_year_start,
                calculated.years_worked,
                calculated.current_year_start
            FROM sales_tracks
            JOIN profiles ON sales_tracks.user_id = profiles.user_id
            JOIN (
                SELECT
                    user_id,
                    contract_year_start,
                    TIMESTAMPDIFF(YEAR, contract_year_start, CURDATE()) -
                        CASE
                            WHEN CURDATE() < DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(contract_year_start), '-', DAY(contract_year_start))) THEN 1
                            ELSE 0
                        END AS years_worked,
                    CASE
                        WHEN CURDATE() < DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(contract_year_start), '-', DAY(contract_year_start))) THEN
                            DATE(CONCAT(YEAR(CURDATE()) - 1, '-', MONTH(contract_year_start), '-', DAY(contract_year_start)))
                        ELSE
                            DATE(CONCAT(YEAR(CURDATE()), '-', MONTH(contract_year_start), '-', DAY(contract_year_start)))
                    END AS current_year_start
                FROM profiles
            ) AS calculated ON sales_tracks.user_id = calculated.user_id
            WHERE sales_tracks.status = 'close'
             AND sales_tracks.closing_date >= calculated.current_year_start
            GROUP BY sales_tracks.user_id, sales_tracks.business_id, profiles.contract_year_start, calculated.years_worked, calculated.current_year_start;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTs agent_earning_views');
    }
};
