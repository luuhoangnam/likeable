<?php

namespace Namest\Likeable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Trait LikeableTrait
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Namest\Likeable
 *
 * @method static QueryBuilder|EloquentBuilder|$this likedBy($value)
 */
trait LikeableTrait
{
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

        $query->getQuery()
              ->join('likes', 'likes.likeable_id', '=', "{$table}.id")
              ->where('likes.likeable_type', '=', get_class($this))
              ->where('likes.liker_type', '=', get_class($liker))
              ->where('likes.liker_id', '=', $liker->getKey());

        return $builder;
    }
}
