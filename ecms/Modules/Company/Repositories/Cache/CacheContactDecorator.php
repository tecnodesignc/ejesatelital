<?php

namespace Modules\Company\Repositories\Cache;

use Modules\Company\Repositories\ContactRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheContactDecorator extends BaseCacheDecorator implements ContactRepository
{
    public function __construct(ContactRepository $contact)
    {
        parent::__construct();
        $this->entityName = 'company.contacts';
        $this->repository = $contact;
    }
}
