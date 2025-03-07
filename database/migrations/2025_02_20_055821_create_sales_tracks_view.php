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

        DB::statement("CREATE VIEW sales_tracks_view AS
        SELECT
            sales_tracks.id,
            users.first_name AS user_first_name,
            users.last_name AS user_last_name,
            properties.address,
            properties.created_at,
            properties.price,
            properties.expiration_date,
            properties.source,

            co_agent_user.first_name AS co_agent_first_name,
            co_agent_user.last_name AS co_agent_last_name,
            properties.co_list_percentage,

            sales_tracks.user_id,
            sales_tracks.property_id,

            sales_tracks.status,
            sales_tracks.date_under_contract,
            sales_tracks.closing_date,
            sales_tracks.purchase_price,
            sales_tracks.buyer_seller,
            sales_tracks.referral_fee_pct,
            sales_tracks.commission_on_sale,
            sales_tracks.note,
            sales_tracks.close_date,

            sales_tracks.business_id

        FROM sales_tracks
        JOIN users ON users.id = sales_tracks.user_id
        JOIN properties ON properties.id = sales_tracks.property_id

        LEFT JOIN users AS agent_user ON agent_user.id = properties.agent
        LEFT JOIN users AS co_agent_user ON co_agent_user.id = properties.co_agent");
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS sales_tracks_view');
    }
};
