<?php

namespace Halalsoft\LaravelDynamicColumn;


trait HasDynamicColumn
{

    /**
     * Boot the MariaDB Dynamic Column  trait.
     *
     * @return void
     */
    protected static function bootHasDynamicColumn()
    {
        static::addGlobalScope(new DynamicScope());
        static::saving(
            function($model) {
                foreach ($model->getCasts() as $column => $cast) {
                    if ($cast == 'Halalsoft\LaravelDynamicColumn\Dynamic') {
                        $model->$column = $model->$column;
                    }
                }
            }
        );
    }


    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new DynamicBuilder(
            $connection, $connection->setQueryGrammar(new DynamicGrammar())->getQueryGrammar(),
            $connection->getPostProcessor(), $this
        );
    }


    public function getDynamicColumns()
    {
        $columns = [];
        foreach ($this->getCasts() as $column => $cast) {
            if ($cast == "Halalsoft\LaravelDynamicColumn\Dynamic") {
                $columns[] = $column;
            }
        }

        return $columns;
    }

}