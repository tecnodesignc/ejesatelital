<?php

namespace Modules\Polls\Repositories\Cache;

use Modules\Polls\Repositories\QuestionTypeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheQuestionTypeDecorator extends BaseCacheDecorator implements QuestionTypeRepository
{
    public function __construct(QuestionTypeRepository $questiontype)
    {
        parent::__construct();
        $this->entityName = 'polls.questiontypes';
        $this->repository = $questiontype;
    }
}
