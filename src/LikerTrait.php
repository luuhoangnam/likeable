<?php

namespace Namest\Likeable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Class LikerTrait
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Namest\Likeable
 *
 */
trait LikerTrait
{
    /**
     * $user = User::find(1);
     * $post = Post::find(3);
     *
     * $user->like($post);
     *
     * @param Model $model
     *
     * @return Like
     */
    public function like(Model $model)
    {
        $like = new Like;

        $like->liker_id      = $this->getKey();
        $like->liker_type    = get_class($this);
        $like->likeable_id   = $model->getKey();
        $like->likeable_type = get_class($model);

        $like->save();

        return $like;
    }

    /**
     * @param Model $model
     *
     * @return bool|null
     */
    public function unlike(Model $model)
    {
        /** @var Model $like */
        $like = Like::where('liker_id', '=', $this->getKey())
                    ->where('liker_type', '=', get_class($this))
                    ->where('likeable_id', '=', $model->getKey())
                    ->where('likeable_type', '=', get_class($model))
                    ->first();

        return $like->delete();
    }

    /**
     * @return HasMany
     */
    public function likes()
    {
        $relation = $this->hasMany(Like::class, 'liker_id', 'id');
        $relation->getQuery()->where('liker_type', '=', get_class($this));

        return $relation;
    }
}
