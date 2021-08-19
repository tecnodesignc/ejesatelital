<?php

namespace Modules\Polls\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class PollTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;
    protected $fillable = ['title','slug','description'];
    protected $table = 'polls__poll_translations';


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
