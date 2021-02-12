<?php

namespace Halalsoft\LaravelDynamicColumn;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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
    private $dynamicColumns;

    public function __construct(
        ConnectionInterface $connection,
        Grammar $grammar = null,
        Processor $processor = null,
        Model $model = null
    ) {
        $this->connection     = $connection;
        $this->grammar        = $grammar ?: $connection->getQueryGrammar();
        $this->processor      = $processor ?: $connection->getPostProcessor();
        $this->model          = $model;
        $this->dynamicColumns = $this->model->getDynamicColumns() ?? [];
    }


    /**
     * Override a basic where clause to the query.
     *
     * @param  Closure|string|array  $column
     * @param  mixed  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if ($this->model !== null && !empty($this->dynamicColumns)) {
            if (strpos($column, '->')) {
                $parts = explode('->', $column, 2);
                if (in_array($parts[0], $this->dynamicColumns)) {
                    $column = DB::raw("COLUMN_GET(`$parts[0]`, '$parts[1]' as char)");
                }
            }
        }

        parent::where($column, $operator, $value, $boolean);
    }


    /**
     * Add a "where null" clause to the query.
     *
     * @param  string|array  $columns
     * @param  string  $boolean
     * @param  bool  $not
     *
     * @return $this
     */
    public function whereNull($columns, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotNull' : 'Null';

        foreach (Arr::wrap($columns) as $column) {
            if ($this->model !== null && !empty($this->dynamicColumns)) {
                if (strpos($column, '->')) {
                    $parts = explode('->', $column, 2);
                    if (in_array($parts[0], $this->dynamicColumns)) {
                        $column = DB::raw("COLUMN_GET(`$parts[0]`, '$parts[1]' as char)");
                    }
                }
            }
            $this->wheres[] = compact('type', 'column', 'boolean');
        }

        return $this;
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

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array|string  $columns
     *
     * @return Collection
     */
    public function get($columns = ['*'])
    {
        if ($this->model !== null && !empty($this->dynamicColumns)) {
            $i = 0;
            foreach ($this->wheres as $where) {
                if (strpos($where['column'], '->')) {
                    $parts = explode('->', $where['column'], 2);
                    if (in_array($parts[0], $this->dynamicColumns)) {
                        $this->wheres[$i]['column'] = DB::raw("COLUMN_GET(`$parts[0]`, '$parts[1]' as char)");
                    }
                }

                $i++;
            }
        }

        return collect(
            $this->onceWithColumns(
                Arr::wrap($columns),
                function() {
                    return $this->processor->processSelect($this, $this->runSelect());
                }
            )
        );
    }

}
