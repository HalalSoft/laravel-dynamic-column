<?php

namespace Halalsoft\LaravelDynamicColumn;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DynamicScope implements Scope
{


    public function apply(Builder $builder, Model $model)
    {
        $dynamicColumns = $model->getDynamicColumns();
        if (empty($builder->getQuery()->columns)) {
            foreach ($dynamicColumns as $column) {
                $builder = $builder->select(['*'])->addSelect(DB::raw("COLUMN_JSON($column) as $column"));
            }
        } elseif (in_array('*', $builder->getQuery()->columns)) {
            foreach ($dynamicColumns as $column) {
                $builder = $builder->addSelect(DB::raw("COLUMN_JSON($column) as $column"));
            }
        } else {
            foreach ($builder->getQuery()->columns as $column) {
                if (in_array($column, $dynamicColumns)) {
                    $builder = $builder->addSelect(DB::raw("COLUMN_JSON($column) as $column"));
                }
            }
        }

        return $builder;
    }
}