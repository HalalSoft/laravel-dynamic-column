<?php

namespace Halalsoft\LaravelDynamicColumn;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dynamic implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return json_decode($value, true);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if (is_array($value)) {
            $values = '';
            foreach ($value as $k => $v) {
                $values .= ($values ? ',' : '')."'$k','$v'";
            }

            return DB::raw("column_create($values)");
        } else {
            return $value;
        }
    }
}