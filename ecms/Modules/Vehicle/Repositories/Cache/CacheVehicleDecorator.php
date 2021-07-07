<?php

namespace Modules\Vehicle\Repositories\Cache;

use Modules\Vehicle\Repositories\VehicleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVehicleDecorator extends BaseCacheDecorator implements VehicleRepository
{
    public function __construct(VehicleRepository $vehicle)
    {
        parent::__construct();
        $this->entityName = 'vehicle.vehicles';
        $this->repository = $vehicle;
    }
}
