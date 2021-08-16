<?php


namespace Modules\Vehicle\Entities;

/**
 * Class Status
 * @package Modules\Blog\Entities
 */

class Type
{
    const HEAVYMACHINERY = 0;
    const VEHICLES = 1;
    const MOTORCYCLE = 2;
    const OTHER = 3;
    /**
     * @var array
     */
    private $type = [];

    public function __construct()
    {
        $this->type = [
            self::HEAVYMACHINERY => trans('vehicle::type.heavy machinery'),
            self::VEHICLES => trans('vehicle::type.vehicle'),
            self::MOTORCYCLE => trans('vehicle::type.motorcycle'),
            self::OTHER => trans('vehicle::type.other'),
        ];
    }

    /**
     * Get the available type
     * @return array
     */
    public function lists()
    {
        return $this->type;
    }

    /**
     * Get the post status
     * @param int $statusId
     * @return string
     */
    public function get($statusId)
    {
        if (isset($this->type[$statusId])) {
            return $this->type[$statusId];
        }

        return $this->type[self::VEHICLES];
    }
}
