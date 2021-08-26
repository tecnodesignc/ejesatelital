<?php

namespace Modules\Vehicle\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Vehicle\Database\Seeders\BrandTableSeeder;

class VehicleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('vehicle__brands')->truncate();
        \DB::table('vehicle__brand_translations')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(BrandTableSeeder::class);
    }
}
