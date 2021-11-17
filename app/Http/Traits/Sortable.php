<?php

namespace App\Http\Traits;

trait Sortable
{
    /**
     * @var string
     */
    public $sortBy = 'created_at';

    /**
     * @var string
     */
    public $sortOrder = 'asc';

    /**
     * @param string $sortBy
     *
     * @return [type]
     */
    public function setSortBy($sortBy = 'created_at')
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @param string $sortOrder
     *
     * @return [type]
     */
    public function setSortOrder($sortOrder = 'desc')
    {
        $this->sortOrder = $sortOrder;
    }
}
