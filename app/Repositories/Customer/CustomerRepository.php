<?php

namespace App\Repositories\Customer;

use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{

    private $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function list($paginate = null, $filters = null )
    {
        $query = $this->model->newQuery();

        if (!empty($filters['country'])) {
            $query->where('phone', 'like', "(%{$filters['country']}%)%");
        }

        $perPage = $paginate ?? 10;
        
        return $query->paginate($perPage);
    }

}
