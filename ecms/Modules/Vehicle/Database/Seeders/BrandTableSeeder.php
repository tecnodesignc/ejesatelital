<?php

namespace Modules\Vehicle\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Vehicle\Repositories\BrandRepository;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $brand = app(BrandRepository::class);
        $path = base_path('Modules/Vehicle/Assets/js/brands.json');
        $brands = json_decode(file_get_contents($path), true);


         foreach ($brands as $key => $item){
             $brand->create($item);
         }

    }
}
