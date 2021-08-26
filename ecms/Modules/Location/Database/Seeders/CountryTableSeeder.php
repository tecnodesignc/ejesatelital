<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ilocations\Entities\City;
use Modules\Location\Repositories\CountryRepository;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $country = app(CountryRepository::class);
        $path = base_path('Modules/Location/Assets/js/countries.json');
        $countries = json_decode(file_get_contents($path), true);


         foreach ($countries as $key => $item){
             $country->create($item);
         }

    }
}
