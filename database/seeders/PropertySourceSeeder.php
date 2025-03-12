<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'Spears Group Lead: Grasshopper Call',
            'Spears Group Lead: Grasshopper Text',
            'Spears Group Lead: Leadership Lead',
            'Spears Group Lead: Airport Banner Text',
            'Spears Group Lead: Website Lead',
            'Spears Group: SOI Database Lead',
            'Social Media',
            'Postcard',
            'Compass Referral',
            'Client Referral',
            'Compass Lead',
            'Door Knocking',
            'Open House',
            'Cold Calling',
            'Repeat Client',
            'Sphere of Influence'
        ];


        foreach( $sources as $source )
        {
            DB::table('property_sources')->insert([
                'slug' => Helper::generateUniqueSlug($source, 'property_sources'),
                'name' => $source,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
