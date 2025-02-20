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
        DB::statement("CREATE VIEW sales_tracks_view AS
                   SELECT
                        users.first_name,
                        users.last_name,
                        properties.address,
                        sales_tracks.id,
                        sales_tracks.user_id,
                        sales_tracks.property_id,
                        sales_tracks.price,
                        sales_tracks.status,
                        sales_tracks.expiration_date,
                        sales_tracks.note
                   FROM sales_tracks
                   JOIN users ON users.id = sales_tracks.user_id
                   JOIN properties ON properties.id = sales_tracks.property_id");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_tracks_view');
    }
};
