<?php

namespace Modules\Location\Repositories\Cache;

use Modules\Location\Repositories\CityRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCityDecorator extends BaseCacheDecorator implements CityRepository
{
    public function __construct(CityRepository $city)
    {
        parent::__construct();
        $this->entityName = 'location.cities';
        $this->repository = $city;
    }
}
