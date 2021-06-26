<?php

namespace Modules\Location\Repositories\Cache;

use Modules\Location\Repositories\NeighborhoodRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNeighborhoodDecorator extends BaseCacheDecorator implements NeighborhoodRepository
{
    public function __construct(NeighborhoodRepository $neighborhood)
    {
        parent::__construct();
        $this->entityName = 'location.neighborhoods';
        $this->repository = $neighborhood;
    }
}
