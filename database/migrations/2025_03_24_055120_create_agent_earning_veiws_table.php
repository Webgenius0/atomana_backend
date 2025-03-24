<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS agent_earning_views');
        DB::statement("
            CREATE VIEW agent_earning_views AS
            SELECT
                st.user_id,
                st.business_id,
                COUNT(st.id) AS sales_closed,
                SUM(st.purchase_price) AS dollars_on_closed_deals_ytd,
                ytc.current_year_start,
                COALESCE(
                    ROUND(
                        (SUM(st.purchase_price) * 100) /
                        (SELECT SUM(purchase_price) FROM sales_tracks WHERE status = 'close' AND closing_date >= ytc.current_year_start),
                        2
                    ),
                    0
                ) AS percentage_total_dollars_on_close_deal,
                SUM(sev.gross_commission_income) AS gross_commission_income_ytd,
                SUM(sev.brokerage_cut) AS brokerage_cut_ytd,
                SUM(sev.net_commission) AS net_commission_ytd,
                SUM(sev.agent_net_income) AS agent_net_income_ytd,
                SUM(sev.group_gross_income) AS group_gross_income_ytd,
                SUM(sev.group_gross_income) AS group_net_ytd

            FROM sales_tracks st
            JOIN user_y_t_c_views ytc ON st.user_id = ytc.user_id
            JOIN business_info_views bi ON st.business_id = bi.business_id
            JOIN sales_earning_view sev ON st.user_id = sev.user_id AND sev.closing_date >= ytc.current_year_start
            WHERE st.status = 'close'
                AND st.closing_date >= ytc.current_year_start
            GROUP BY st.user_id, st.business_id, ytc.current_year_start;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS agent_earning_views');
    }
};
