<?php

namespace Modules\Location\Repositories\Cache;

use Modules\Location\Repositories\PolygonRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePolygonDecorator extends BaseCacheDecorator implements PolygonRepository
{
    public function __construct(PolygonRepository $polygon)
    {
        parent::__construct();
        $this->entityName = 'location.polygons';
        $this->repository = $polygon;
    }
}
