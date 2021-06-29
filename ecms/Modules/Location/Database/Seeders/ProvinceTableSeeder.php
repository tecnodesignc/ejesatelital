<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Location\Repositories\CountryRepository;
use Modules\Location\Repositories\ProvinceRepository;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $province = app(ProvinceRepository::class);
        $country = app(CountryRepository::class);
        $path = base_path('/Modules/Location/Assets/js/provinces.json');
        $provinces = json_decode(file_get_contents($path), true);
        $countries = $country->all();

        foreach ($countries as $keyCountry => $countryItem)
            foreach ($provinces as $keyProvince => $item)
                if ($countryItem->iso_2 == $item['country'])
                    $province->create([
                        'name' => $item['region'],
                        'iso_2' => $item['iso_2'],
                        'country_id' => $countryItem->id
                    ]);
    }
}
