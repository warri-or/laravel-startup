<?php

namespace App\Http\Traits;

trait Relationable
{
    public $relations = [];

    /**
     * @param null $relations
     *
     * @return void [type]
     */
    public function setRelations($relations = null)
    {
        $this->relations = $relations;
    }
}
