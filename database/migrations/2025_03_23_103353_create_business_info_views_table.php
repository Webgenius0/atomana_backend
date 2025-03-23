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
            SELECT business_id, SUM(purchase_price) AS business_total_ytc
                        FROM sales_tracks
                        WHERE sales_tracks.status = 'close'
                        GROUP BY business_id;
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
