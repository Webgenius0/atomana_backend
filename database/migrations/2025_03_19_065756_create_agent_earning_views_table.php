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
                COUNT(sales_tracks.id) AS sales_closed,
                SUM(sales_tracks.purchase_price) AS closed_sales_total,
                (SUM(sales_tracks.purchase_price) / (SELECT SUM(purchase_price) FROM sales_tracks WHERE status = 'close')) * 100 AS percentage_of_closed_deals,
                TIMESTAMPDIFF(YEAR,
                    DATE_ADD(profiles.contract_year_start, INTERVAL MONTH(CURDATE()) - MONTH(profiles.contract_year_start) MONTH),
                    CURDATE()) AS current_contract_year,
                ROUND(SUM(
                    CASE
                        WHEN sales_tracks.override_split IS NOT NULL THEN
                            sales_tracks.commission_on_sale - (sales_tracks.commission_on_sale * sales_tracks.override_split / 100)
                        ELSE
                            sales_tracks.commission_on_sale
                    END
                ), 2) AS agent_commission_split
            FROM sales_tracks
            JOIN profiles ON sales_tracks.user_id = profiles.user_id
            WHERE sales_tracks.status = 'close'
            AND sales_tracks.closing_date >= DATE_ADD(profiles.contract_year_start, INTERVAL MONTH(profiles.contract_year_start) - 1 MONTH)
            AND sales_tracks.closing_date < DATE_ADD(DATE_ADD(profiles.contract_year_start, INTERVAL 1 YEAR), INTERVAL MONTH(profiles.contract_year_start) - 1 MONTH)
            GROUP BY sales_tracks.user_id, profiles.contract_year_start
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
