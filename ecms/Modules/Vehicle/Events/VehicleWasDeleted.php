<?php

namespace Modules\Vehicle\Events;

use Modules\Media\Contracts\DeletingMedia;

class VehicleWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private string $vehicleClass;
    /**
     * @var int
     */
    private $vehicleId;

    public function __construct($vehicleId, $vehicleClass)
    {
        $this->vehicleClass = $vehicleClass;
        $this->vehicleId = $vehicleId;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->vehicleId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->vehicleClass;
    }
}
