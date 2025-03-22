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
        DB::statement('DROP VIEW IF EXISTS agent_earning_views');
        DB::statement("
        CREATE VIEW agent_earning_views AS
            SELECT
                sales_tracks.user_id,
                sales_tracks.business_id,
                COUNT(sales_tracks.id) AS sales_closed,
                profiles.contract_year_start,
                ytc.current_year_start,
                ytc.years_worked,
                SUM(sales_tracks.purchase_price) AS dollars_on_closed_deals_ytd,

                ROUND((user_data.user_total_purchase_price * 100) / business_data.business_total, 2) AS total_dollars_on_close_deal_percentage,

                ROUND(
                    SUM(
                        (sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100)
                        - (
                            CASE
                                WHEN sales_tracks.override_split IS NOT NULL
                                THEN ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * sales_tracks.override_split / 100)
                                ELSE ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * profiles.total_commission_this_contract_year / 100)
                            END
                        )
                    ), 2) AS agent_commission,


                ROUND((SUM(
                    (sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100)
                    - (
                        CASE
                            WHEN sales_tracks.override_split IS NOT NULL
                            THEN ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * sales_tracks.override_split / 100)
                            ELSE ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * profiles.total_commission_this_contract_year / 100)
                        END
                    )
                ) * 100) / SUM(sales_tracks.purchase_price), 2) AS agent_commission_split,


                ROUND(SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale),2) AS gross_commission_income_ytd,

                ROUND(SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale) * 0.10, 2) AS brokerage_cur_ytd,

                ROUND(SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale)
                - (SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale) * 0.10), 2) AS net_commission_ytd,


                ROUND((SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale)
                - (SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale) * 0.10))
                * ROUND((SUM(
                    (sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100)
                    - (
                        CASE
                            WHEN sales_tracks.override_split IS NOT NULL
                            THEN ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * sales_tracks.override_split / 100)
                            ELSE ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * profiles.total_commission_this_contract_year / 100)
                        END
                    )
                ) * 100) / SUM(sales_tracks.purchase_price), 2) / 100) AS net_income_ytd,


                ROUND(ROUND(SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale)
                - (SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale) * 0.10), 2) -
                ROUND((SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale)
                - (SUM(sales_tracks.purchase_price * sales_tracks.commission_on_sale) * 0.10))
                * ROUND((SUM(
                    (sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100)
                    - (
                        CASE
                            WHEN sales_tracks.override_split IS NOT NULL
                            THEN ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * sales_tracks.override_split / 100)
                            ELSE ((sales_tracks.purchase_price * sales_tracks.commission_on_sale / 100) * profiles.total_commission_this_contract_year / 100)
                        END
                    )
                ) * 100) / SUM(sales_tracks.purchase_price), 2) / 100) ,2)AS gross_net_income_ytd

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
            ) AS ytc ON sales_tracks.user_id = ytc.user_id

            JOIN (
               SELECT business_id, SUM(purchase_price) AS business_total
                    FROM sales_tracks
                    WHERE sales_tracks.status = 'close'
                    GROUP BY business_id
            ) AS business_data ON sales_tracks.business_id = business_data.business_id

            JOIN (
                SELECT user_id, SUM(purchase_price) AS user_total_purchase_price
                    FROM sales_tracks
                    WHERE sales_tracks.status = 'close'
                    GROUP BY user_id
            ) AS user_data ON sales_tracks.user_id = user_data.user_id

            WHERE sales_tracks.status = 'close'
             AND sales_tracks.closing_date >= ytc.current_year_start
            GROUP BY sales_tracks.user_id, sales_tracks.business_id, profiles.contract_year_start, ytc.years_worked, ytc.current_year_start;
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
