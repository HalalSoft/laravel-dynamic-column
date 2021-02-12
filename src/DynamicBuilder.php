<?php

namespace Halalsoft\LaravelDynamicColumn;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;

class DynamicBuilder extends QueryBuilder
{

    private $model;

    public function __construct(
        ConnectionInterface $connection,
        Grammar $grammar = null,
        Processor $processor = null,
        Model $model = null
    ) {
        $this->connection = $connection;
        $this->grammar    = $grammar ?: $connection->getQueryGrammar();
        $this->processor  = $processor ?: $connection->getPostProcessor();
        $this->model      = $model;
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $dynamicColumns = $this->model->getDynamicColumns() ?? [];
        if ($this->model !== null && !empty($dynamicColumns)) {
            if (strpos($column, '->')) {
                $parts = explode('->', $column, 2);
                if (in_array($parts[0], $dynamicColumns)) {
                    $column = DB::raw("COLUMN_GET(`$parts[0]`, '$parts[1]' as char)");
                }
            }
        }

        parent::where($column, $operator, $value, $boolean);
    }

    public function orWhere($column, $operator = null, $value = null, $boolean = 'and')
    {
        if ($this->model !== null && isset($this->model::$dynamicColumns)) {
            if (strpos($column, '->')) {
                $parts = explode('->', $column, 2);
                if (in_array($parts[0], $this->model::$dynamicColumns)) {
                    $column = DB::raw("COLUMN_GET(`$parts[0]`, '$parts[1]' as char)");
//                    dd($column);
                }
            }
        }

        parent::where($column, $operator, $value, $boolean);
    }

    public function whereDynamicExists($column, $value = null, $boolean = 'and', $not = false)
    {
        $type = 'DynamicColumnExists';

        $this->wheres[] = compact('type', 'column', 'value', 'boolean', 'not');

        if (!$value instanceof Expression) {
            $this->addBinding($this->grammar->prepareBindingForJsonContains($value));
        }

        return $this;
    }

}
