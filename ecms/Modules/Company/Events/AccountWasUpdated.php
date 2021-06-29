<?php

namespace Modules\Company\Events;

use Modules\Company\Entities\Account;
use Modules\Media\Contracts\StoringMedia;

class AccountWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Account
     */
    public $account;

    public function __construct($account, array $data)
    {
        $this->data = $data;
        $this->account = $account;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->account;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
