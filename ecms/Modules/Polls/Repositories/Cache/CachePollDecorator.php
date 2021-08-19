<?php

namespace Modules\Polls\Repositories\Cache;

use Modules\Polls\Repositories\PollRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePollDecorator extends BaseCacheDecorator implements PollRepository
{
    public function __construct(PollRepository $poll)
    {
        parent::__construct();
        $this->entityName = 'polls.polls';
        $this->repository = $poll;
    }
}
