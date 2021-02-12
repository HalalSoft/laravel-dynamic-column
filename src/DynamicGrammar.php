<?php

namespace Halalsoft\LaravelDynamicColumn;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\MySqlGrammar;

/**
 * Class DynamicGrammar
 *
 */
class DynamicGrammar extends MySqlGrammar
{
    /**
     * Compile a "JSON contains" statement into SQL.
     *
     * @param  string  $column
     * @param  string  $value
     *
     * @return string
     */
    public function compileDynamicColumn($column, $value, $operator = '=')
    {
        [$field, $key] = $this->wrapDynamicField($column);

        return 'COLUMN_GET('.$field.', "'.$key.'" as char) '.$operator.' '.$value.'';
    }

    public function compileDynamicExists($column, $value)
    {
        [$field, $key] = $this->wrapDynamicField($column);

        if ($key) {
            return 'COLUMN_EXISTS('.$field.', "'.$key.'")';
        } else {
            return 'COLUMN_EXISTS('.$column.', '.$this->parameter($value).')';
        }
    }


    /**
     * Compile a "where JSON contains" clause.
     *
     * @param  Builder  $query
     * @param  array  $where
     *
     * @return string
     */
    protected function whereDynamicColumnExists(Builder $query, $where)
    {
        $not = $where['not'] ? 'not ' : '';


        return $not.$this->compileDynamicExists(
                $where['column'],
                $this->parameter($where['value'])
            );
    }


    /**
     * Split the given JSON selector into the field and the optional path and wrap them separately.
     *
     * @param  string  $column
     *
     * @return array
     */
    protected function wrapDynamicField($column)
    {
        $parts = explode('->', $column, 2);

        $field = $this->wrap($parts[0]);

//        $path = count($parts) > 1 ? ', '.$this->wrapJsonPath($parts[1], '->') : '';

        return [$field, $parts[1] ?? null];
    }
}