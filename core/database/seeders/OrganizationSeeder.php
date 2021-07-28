<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('organization_configs')->insert([
            'thankyou_message' => 'Thanks for trusting us',
            'company_name'=> 'Example',
            'logo'=> 'logo.png',
            'phone_number'=> '111-111-111',
            'tax_id' => '00.000.000.000.000'
        ]);
    }
}
