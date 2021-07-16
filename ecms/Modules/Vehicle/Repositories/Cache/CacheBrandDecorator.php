<?php

namespace Modules\Vehicle\Repositories\Cache;

use Modules\Vehicle\Repositories\BrandRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBrandDecorator extends BaseCacheDecorator implements BrandRepository
{
    public function __construct(BrandRepository $brand)
    {
        parent::__construct();
        $this->entityName = 'vehicle.brands';
        $this->repository = $brand;
    }
}
