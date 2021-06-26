<?php

namespace Modules\Location\Repositories\Cache;

use Modules\Location\Repositories\CountryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCountryDecorator extends BaseCacheDecorator implements CountryRepository
{
    public function __construct(CountryRepository $country)
    {
        parent::__construct();
        $this->entityName = 'location.countries';
        $this->repository = $country;
    }
}
