<?php

namespace App\Repositories\Customer;


interface CustomerRepositoryInterface
{
    public function list($paginate = null, $filters = null);
}
