<?php


namespace Modules\Polls\Presenters;
use Laracasts\Presenter\Presenter;
use Modules\Polls\Repositories\AnswerRepository;

class QuestionPresenter extends Presenter
{

     /**
      * @var \Modules\Polls\Entities\Type
      */
     protected $type;

     /**
      * @var QuestionRepository
      */
     private $answer;

     public function __construct($entity)
     {
         parent::__construct($entity);
         $this->type= app('Modules\Polls\Entities\Type');
         $this->answer= app('Modules\Polls\Repositories\AnswerRepository');
     }

     /**
      * Get The Type Question
      *@returns string
      */

     public function type_question():string
     {
         return $this->type->get($this->entity->type);
     }

}
