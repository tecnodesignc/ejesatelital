<?php

namespace Modules\Polls\Events;

use Modules\Media\Contracts\DeletingMedia;

class AnswerWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private string $answerClass;
    /**
     * @var int
     */
    private $answerId;

    public function __construct($answerId, $answerClass)
    {
        $this->answerClass = $answerClass;
        $this->answerId = $answerId;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->answerId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->answerClass;
    }
}
