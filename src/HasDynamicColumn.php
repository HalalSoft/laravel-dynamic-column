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
    }


    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new DynamicBuilder(
            $connection, $connection->setQueryGrammar(new DynamicGrammar())->getQueryGrammar(),
            $connection->getPostProcessor(), $this
        );
    }
}