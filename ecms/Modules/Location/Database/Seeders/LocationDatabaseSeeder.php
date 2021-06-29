<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LocationDatabaseSeeder extends Seeder
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
        \DB::table('location__countries')->truncate();
        \DB::table('location__country_translations')->truncate();

        \DB::table('location__provinces')->truncate();
        \DB::table('location__province_translations')->truncate();

        \DB::table('location__cities')->truncate();
        \DB::table('location__city_translations')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call(CountryTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(CityTableSeeder::class);
    }
}
