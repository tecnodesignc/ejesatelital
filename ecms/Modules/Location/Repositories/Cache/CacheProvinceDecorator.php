<?php

namespace Modules\Location\Repositories\Cache;

use Modules\Location\Repositories\ProvinceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProvinceDecorator extends BaseCacheDecorator implements ProvinceRepository
{
    public function __construct(ProvinceRepository $province)
    {
        parent::__construct();
        $this->entityName = 'location.provinces';
        $this->repository = $province;
    }
}
