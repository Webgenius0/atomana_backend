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
        DB::statement('DROP VIEW IF EXISTS sales_tracks_view');

        // DB::statement("CREATE VIEW sales_tracks_view AS
        //            SELECT
        //                 sales_tracks.id,
        //                 users.first_name,
        //                 users.last_name,
        //                 properties.address,
        //                 sales_tracks.user_id,
        //                 sales_tracks.property_id,
        //                 sales_tracks.price,
        //                 sales_tracks.status,
        //                 sales_tracks.expiration_date,
        //                 sales_tracks.note,
        //                 sales_tracks.business_id
        //            FROM sales_tracks
        //            JOIN users ON users.id = sales_tracks.user_id
        //            JOIN properties ON properties.id = sales_tracks.property_id");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS sales_tracks_view');
    }
};
