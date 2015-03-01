<?php

namespace Namest\Likeable;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 *
 * @property int    liker_id
 * @property string liker_type
 * @property int    likeable_id
 * @property string likeable_type
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Namest\Likeable
 *
 */
class Like extends Model
{
    /**
     * @return Model
     */
    public function getLikerAttribute()
    {
        return forward_static_call([$this->liker_type, 'find'], $this->liker_id);
    }

    /**
     * @return Model
     */
    public function getLikeableAttribute()
    {
        return forward_static_call([$this->likeable_type, 'find'], $this->likeable_id);
    }
}
