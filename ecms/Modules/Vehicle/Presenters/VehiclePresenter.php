<?php


namespace Modules\Vehicle\Presenters;
use Laracasts\Presenter\Presenter;
use Modules\Vehicle\Repositories\VehicleRepository;

class VehiclePresenter extends Presenter
{

     /**
      * @var \Modules\Vehicle\Entities\Type
      */
     protected $type;

     /**
      * @var VehicleRepository
      */
     private $vehicle;

     public function __construct($entity)
     {
         parent::__construct($entity);
         $this->type= app('Modules\Vehicle\Entities\Type');
         $this->vehicle= app('Modules\Vehicle\Repositories\VehicleRepository');
     }

     /**
      * Get The Type Vehicle
      *@returns string
      */

     public function type_vehicle():string
     {
         return $this->type->get($this->entity->type);
     }

}
