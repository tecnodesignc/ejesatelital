<?php

namespace Modules\Company\Events;

use Modules\Media\Contracts\DeletingMedia;

class AccountWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $accountClass;
    /**
     * @var int
     */
    private $postId;

    public function __construct($accountId, $accountClass)
    {
        $this->accountClass = $accountClass;
        $this->accountId = $accountId;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->accountId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->accountClass;
    }
}
