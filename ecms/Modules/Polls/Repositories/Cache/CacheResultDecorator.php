<?php

namespace Modules\Polls\Repositories\Cache;

use Modules\Polls\Repositories\ResultRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheResultDecorator extends BaseCacheDecorator implements ResultRepository
{
    public function __construct(ResultRepository $result)
    {
        parent::__construct();
        $this->entityName = 'polls.results';
        $this->repository = $result;
    }
}
