<?php

namespace Modules\Company\Repositories\Cache;

use Modules\Company\Repositories\AccountTypeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAccountTypeDecorator extends BaseCacheDecorator implements AccountTypeRepository
{
    public function __construct(AccountTypeRepository $accounttype)
    {
        parent::__construct();
        $this->entityName = 'company.accounttypes';
        $this->repository = $accounttype;
    }
}
