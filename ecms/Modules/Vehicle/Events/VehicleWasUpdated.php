<?php

namespace Modules\Vehicle\Events;

use Modules\Vehicle\Entities\Vehicle;
use Modules\Media\Contracts\StoringMedia;

class VehicleWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Vehicle
     */
    public $vehicle;

    public function __construct(Vehicle $vehicle, array $data)
    {
        $this->data = $data;
        $this->vehicle = $vehicle;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->vehicle;
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
