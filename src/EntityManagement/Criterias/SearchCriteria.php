<?php

namespace Escape\Argon\EntityManagement\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class SearchCriteria implements CriteriaInterface
{
    protected $search;
    protected $limit;

    public function __construct($search, $limit = 5)
    {
        $this->search = $search;
        $this->limit = $limit;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('name', 'LIKE', '%'.$this->search.'%')
            ->take($this->limit);
    }
}
