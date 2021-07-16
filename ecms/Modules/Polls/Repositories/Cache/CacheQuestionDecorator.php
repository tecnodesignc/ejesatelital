<?php

namespace Modules\Polls\Repositories\Cache;

use Modules\Polls\Repositories\QuestionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheQuestionDecorator extends BaseCacheDecorator implements QuestionRepository
{
    public function __construct(QuestionRepository $question)
    {
        parent::__construct();
        $this->entityName = 'polls.questions';
        $this->repository = $question;
    }
}
