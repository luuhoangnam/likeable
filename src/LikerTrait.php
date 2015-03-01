<?php

namespace Namest\Likeable;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Trait LikerTrait
 *
 * @property-read Collection $likes
 *
 * @method static QueryBuilder|EloquentBuilder|$this wasLiked(Model $likeable)
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
        $this->getEventDispatcher()->fire('namest.likeable.liking', [$this, $model]);

        $like = new Like;

        $like->liker_id      = $this->getKey();
        $like->liker_type    = get_class($this);
        $like->likeable_id   = $model->getKey();
        $like->likeable_type = get_class($model);

        $like->save();

        $this->getEventDispatcher()->fire('namest.likeable.liked', [$this, $model, $like]);

        return $like;
    }

    /**
     * @param Model $model
     *
     * @return bool|null
     */
    public function unlike(Model $model)
    {
        $this->getEventDispatcher()->fire('namest.likeable.unliking', [$this, $model]);

        $like = Like::where('liker_id', '=', $this->getKey())
                    ->where('liker_type', '=', get_class($this))
                    ->where('likeable_id', '=', $model->getKey())
                    ->where('likeable_type', '=', get_class($model))
                    ->first();

        $result = $like->delete();

        $this->getEventDispatcher()->fire('namest.likeable.unliked', [$this, $model]);

        return $result;
    }

    /**
     * TODO Optimize performance by reduce SQL query
     *
     * @return array
     */
    public function getLikesAttribute()
    {
        $relation = $this->hasMany(Like::class, 'liker_id', 'id');
        $relation->getQuery()->where('liker_type', '=', get_class($this));

        return new Collection(array_map(function ($like) {
            return forward_static_call([$like['likeable_type'], 'find'], $like['likeable_id']);
        }, $relation->getResults()->toArray()));
    }

    /**
     * @param EloquentBuilder|QueryBuilder $query
     * @param Model                        $likeable
     *
     * @return QueryBuilder
     */
    public function scopeWasLiked($query, Model $likeable)
    {
        $table   = $this->getTable();
        $builder = $query->getQuery();

        $builder->join('likes', 'likes.liker_id', '=', "{$table}.id")
                ->where('likes.liker_type', '=', get_class($this))
                ->where('likes.likeable_id', '=', $likeable->getKey())
                ->where('likes.likeable_type', '=', get_class($likeable));

        return $builder;
    }
}
