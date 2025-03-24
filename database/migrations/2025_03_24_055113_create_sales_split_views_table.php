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
        DB::statement('DROP VIEW IF EXISTS sales_earning_view');
        DB::statement("
            CREATE VIEW sales_earning_view AS
            SELECT
                st.id,
                st.user_id,
                st.business_id,
                st.closing_date,
                st.purchase_price,
                st.commission_on_sale,
                st.override_split,

                -- Calculate getting after commission and round to 2 decimals
                ROUND((st.commission_on_sale * st.purchase_price) / 100, 2) AS getting,

                -- Determine deduct_percentage based on override_split or tiers table
                ROUND(
                    CASE
                        WHEN st.override_split IS NOT NULL THEN st.override_split
                        ELSE (
                            SELECT t.deduct
                            FROM tiers t
                            WHERE t.business_id = st.business_id
                            AND (
                                (st.purchase_price >= t.from AND st.purchase_price <= t.to)
                                OR (t.to IS NULL AND st.purchase_price >= t.from)
                            )
                            LIMIT 1
                        )
                    END, 2
                ) AS deduct_percentage,

                -- Calculate getting after overhead and round to 2 decimals
                ROUND(
                    CASE
                        WHEN st.override_split IS NOT NULL THEN
                            (st.commission_on_sale * st.purchase_price) / 100 - (st.override_split * (st.commission_on_sale * st.purchase_price) / 100) / 100
                        ELSE (
                            SELECT (st.commission_on_sale * st.purchase_price) / 100 - (t.deduct * (st.commission_on_sale * st.purchase_price) / 100) / 100
                            FROM tiers t
                            WHERE t.business_id = st.business_id
                            AND (
                                (st.purchase_price >= t.from AND st.purchase_price <= t.to)
                                OR (t.to IS NULL AND st.purchase_price >= t.from)
                            )
                            LIMIT 1
                        )
                    END, 2
                ) AS net_income,

                -- Calculate agent split and round to 2 decimals
                ROUND(
                    CASE
                        WHEN st.override_split IS NOT NULL THEN
                            (((st.commission_on_sale * st.purchase_price) / 100 - (st.override_split * (st.commission_on_sale * st.purchase_price) / 100) / 100) * 100) / st.purchase_price
                        ELSE
                            100 * (
                                SELECT (st.commission_on_sale * st.purchase_price) / 100 - (t.deduct * (st.commission_on_sale * st.purchase_price) / 100) / 100
                                FROM tiers t
                                WHERE t.business_id = st.business_id
                                AND (
                                    (st.purchase_price >= t.from AND st.purchase_price <= t.to)
                                    OR (t.to IS NULL AND st.purchase_price >= t.from)
                                )
                                LIMIT 1
                            ) / st.purchase_price
                    END, 2
                ) AS user_commision_split,

                -- Show the tier range (from and to) if override_split is NULL
                CASE
                    WHEN st.override_split IS NOT NULL THEN 'Override Split'
                    ELSE CONCAT(
                        (SELECT CONCAT('From: ', t.from, ' To: ', t.to, ' deduct: ', t.deduct)
                        FROM tiers t
                        WHERE t.business_id = st.business_id
                        AND (
                            (st.purchase_price >= t.from AND st.purchase_price <= t.to)
                            OR (t.to IS NULL AND st.purchase_price >= t.from)
                        )
                        LIMIT 1)
                    )
                END AS tier_range

            FROM
                sales_tracks st
            WHERE
                st.status = 'close';

        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS sales_earning_view');
    }
};
