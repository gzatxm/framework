<?php

namespace Immortal\Validation;

use Immortal\Support\Traits\Macroable;

class Rule
{
    use Macroable;

    /**
     * Get a dimensions constraint builder instance.
     *
     * @param  array  $constraints
     * @return \Immortal\Validation\Rules\Dimensions
     */
    public static function dimensions(array $constraints = [])
    {
        return new Rules\Dimensions($constraints);
    }

    /**
     * Get a exists constraint builder instance.
     *
     * @param  string  $table
     * @param  string  $column
     * @return \Immortal\Validation\Rules\Exists
     */
    public static function exists($table, $column = 'NULL')
    {
        return new Rules\Exists($table, $column);
    }

    /**
     * Get an in constraint builder instance.
     *
     * @param  array  $values
     * @return \Immortal\Validation\Rules\In
     */
    public static function in(array $values)
    {
        return new Rules\In($values);
    }

    /**
     * Get a not_in constraint builder instance.
     *
     * @param  array  $values
     * @return \Immortal\Validation\Rules\NotIn
     */
    public static function notIn(array $values)
    {
        return new Rules\NotIn($values);
    }

    /**
     * Get a unique constraint builder instance.
     *
     * @param  string  $table
     * @param  string  $column
     * @return \Immortal\Validation\Rules\Unique
     */
    public static function unique($table, $column = 'NULL')
    {
        return new Rules\Unique($table, $column);
    }
}
