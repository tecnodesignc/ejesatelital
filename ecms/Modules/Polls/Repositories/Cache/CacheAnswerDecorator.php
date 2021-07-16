<?php

namespace Modules\Polls\Repositories\Cache;

use Modules\Polls\Repositories\AnswerRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAnswerDecorator extends BaseCacheDecorator implements AnswerRepository
{
    public function __construct(AnswerRepository $answer)
    {
        parent::__construct();
        $this->entityName = 'polls.answers';
        $this->repository = $answer;
    }
}
