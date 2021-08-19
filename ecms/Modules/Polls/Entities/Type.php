<?php


namespace Modules\Polls\Entities;

/**
 * Class Status
 * @package Modules\Blog\Entities
 */

class Type
{
    const MULTIPLECHOICE = 0;
    const RATINGSCALE = 1;
    const LIKERTSCALES = 2;
    const MATRIX = 3;
    const OPENENDED = 4;
    const RANKING=5;
    const IMAGECHOICE=6;
    const FILEUPLOAD=7;
    const YESNO=8;
    const YESNOSPECIAL=9;
    /**
     * @var array
     */
    private $type = [];

    public function __construct()
    {
        $this->type = [
            self::MULTIPLECHOICE => trans('polls::type.multiple choice'),
            self::RATINGSCALE => trans('polls::type.rating scale'),
            self::LIKERTSCALES => trans('polls::type.likert scale'),
            self::MATRIX => trans('polls::type.matrix'),
            self::OPENENDED => trans('polls::type.open-ended'),
            self::RANKING => trans('polls::type.ranking'),
            self::IMAGECHOICE => trans('polls::type.image choice'),
            self::FILEUPLOAD => trans('polls::type.file upload'),
            self::YESNO => trans('polls::type.yes/no'),
            self::YESNOSPECIAL => trans('polls::type.yes/no special'),

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

        return $this->type[self::MULTIPLECHOICE];
    }
}
