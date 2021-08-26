<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

;

use Modules\Location\Repositories\CityRepository;
use Modules\Location\Repositories\ProvinceRepository;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $city = app(CityRepository::class);

        $path = base_path('Modules/Location/Assets/js/citiesCO.json');
        $cities = json_decode(file_get_contents($path), true);

        foreach ($cities as $key => $item) {


            if (!isset($province->iso_2) || $item['province_iso_2'] != $province->iso_2) {
                $province = $this->provinceSearch($item["province_iso_2"]);
            }

            $city->create([
                "country_id" => $province->country_id,
                "province_id" => $province->id,
                "code" => $item['code'],
                "name" => $item['name']
            ]);
        }
    }

    private function provinceSearch($iso2)
    {
        $provinceRepo = app(ProvinceRepository::class);
        return $provinceRepo->getItem($iso2, json_decode(json_encode(["filter" => ["field" => "iso_2"], "include" => []])));
    }

}
