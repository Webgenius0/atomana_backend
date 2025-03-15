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
        DB::statement('DROP VIEW IF EXISTS leaderboard_views');

        DB::statement("
            CREATE VIEW leaderboard_views AS
            SELECT
                st.business_id,
                st.user_id,
                AVG(CASE WHEN st.status = 'close' THEN st.purchase_price ELSE 0 END) AS avg_sales_price,
                SUM(CASE WHEN st.status = 'close' THEN st.purchase_price ELSE 0 END) AS volume_sales_price,
                SUM(CASE WHEN st.status = 'pending' THEN st.purchase_price ELSE 0 END) AS pending_volume_price,
                SUM(CASE WHEN st.status = 'active' THEN st.purchase_price ELSE 0 END) AS active_volume_price,
                AVG(st.purchase_price) AS average_list_price
            FROM sales_tracks AS st
            GROUP BY st.business_id, st.user_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS leaderboard_views");
    }
};
