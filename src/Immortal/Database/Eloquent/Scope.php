<?php

namespace Immortal\Database\Eloquent;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Immortal\Database\Eloquent\Builder  $builder
     * @param  \Immortal\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
