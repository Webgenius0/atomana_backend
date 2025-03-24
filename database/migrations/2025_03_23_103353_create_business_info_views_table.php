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
        DB::statement('DROP VIEW IF EXISTS business_info_views');
        DB::statement("
            CREATE VIEW business_info_views AS
            SELECT st.business_id, SUM(st.purchase_price) AS business_total_ytc
            FROM sales_tracks st
            JOIN user_y_t_c_views ytc ON st.business_id = ytc.business_id
            WHERE st.status = 'close'
                AND st.closing_date >= ytc.current_year_start
            GROUP BY st.business_id;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS business_info_views');
    }
};
