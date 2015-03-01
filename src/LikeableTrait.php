<?php

namespace Namest\Likeable;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Trait LikeableTrait
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Namest\Likeable
 *
 * @property-read Collection $likers
 *
 * @method static QueryBuilder|EloquentBuilder|$this likedBy($value)
 */
trait LikeableTrait
{
    /**
     * TODO Optimize performance by reduce SQL query
     *
     * @return array
     */
    public function getLikersAttribute()
    {
        $relation = $this->hasMany(Like::class, 'likeable_id', 'id');
        $relation->getQuery()->where('likeable_type', '=', get_class($this));

        return new Collection(array_map(function ($like) {
            return forward_static_call([$like['liker_type'], 'find'], $like['liker_id']);
        }, $relation->getResults()->toArray()));
    }

    /**
     * @param EloquentBuilder|QueryBuilder $query
     * @param Model                        $liker
     *
     * @return QueryBuilder
     */
    public function scopeLikedBy($query, Model $liker)
    {
        $table   = $this->getTable();
        $builder = $query->getQuery();

        $builder->join('likes', 'likes.likeable_id', '=', "{$table}.id")
                ->where('likes.likeable_type', '=', get_class($this))
                ->where('likes.liker_type', '=', get_class($liker))
                ->where('likes.liker_id', '=', $liker->getKey());

        return $builder;
    }
}
