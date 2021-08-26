<?php


namespace Modules\Vehicle\Entities;

/**
 * Class Status
 * @package Modules\Blog\Entities
 */

class Type
{
    const OWN = 0;
    const THIRDPARTY = 1;
    /**
     * @var array
     */
    private $type = [];

    public function __construct()
    {
        $this->type = [
            self::OWN => trans('vehicle::type.own'),
            self::THIRDPARTY => trans('vehicle::type.third party'),
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
    public function get($typeId)
    {

        if (isset($this->type[$typeId])) {
            return $this->type[$typeId];
        }

        return $this->type[self::THIRDPARTY];
    }
}
