<?php

namespace Immortal\Database\Eloquent\Relations;

use Immortal\Database\Eloquent\Model;
use Immortal\Database\Eloquent\Collection;

class HasOne extends HasOneOrMany
{
    /**
     * Indicates if a default model instance should be used.
     *
     * Alternatively, may be a Closure to execute to retrieve default value.
     *
     * @var \Closure|bool
     */
    protected $withDefault;

    /**
     * Return a new model instance in case the relationship does not exist.
     *
     * @param  \Closure|bool  $callback
     * @return $this
     */
    public function withDefault($callback = true)
    {
        $this->withDefault = $callback;

        return $this;
    }

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults()
    {
        return $this->query->first() ?: $this->getDefaultFor($this->parent);
    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param  array   $models
     * @param  string  $relation
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->getDefaultFor($model));
        }

        return $models;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param  array  $models
     * @param  \Immortal\Database\Eloquent\Collection  $results
     * @param  string  $relation
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        return $this->matchOne($models, $results, $relation);
    }

    /**
     * Get the default value for this relation.
     *
     * @param  \Immortal\Database\Eloquent\Model  $model
     * @return \Immortal\Database\Eloquent\Model|null
     */
    protected function getDefaultFor(Model $model)
    {
        if (! $this->withDefault) {
            return;
        }

        $instance = $this->related->newInstance()->setAttribute(
            $this->getPlainForeignKey(), $model->getAttribute($this->localKey)
        );

        if (is_callable($this->withDefault)) {
            return call_user_func($this->withDefault, $instance) ?: $instance;
        }

        if (is_array($this->withDefault)) {
            $instance->forceFill($this->withDefault);
        }

        return $instance;
    }
}
