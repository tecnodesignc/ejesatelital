<?php

namespace Modules\Company\Repositories\Cache;

use Modules\Company\Repositories\AccountRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAccountDecorator extends BaseCacheDecorator implements AccountRepository
{
    public function __construct(AccountRepository $account)
    {
        parent::__construct();
        $this->entityName = 'company.accounts';
        $this->repository = $account;
    }
}
