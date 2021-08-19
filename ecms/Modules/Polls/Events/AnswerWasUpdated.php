<?php

namespace Modules\Polls\Events;

use Modules\Polls\Entities\Answer;
use Modules\Media\Contracts\StoringMedia;

class AnswerWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Answer
     */
    public $answer;

    public function __construct(Answer $answer, array $data)
    {
        $this->data = $data;
        $this->answer = $answer;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->answer;
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
