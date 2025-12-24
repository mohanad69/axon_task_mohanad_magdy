<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Services\PhoneNumberService;

class CustomerController extends Controller
{

    protected $customerRepository;
    protected $phoneNumberService;

    public function __construct(CustomerRepositoryInterface $customerRepository, PhoneNumberService $phoneNumberService)
    {
        $this->customerRepository = $customerRepository;
        $this->phoneNumberService = $phoneNumberService;
    }

    public function index(Request $request)
    {
        $filters = [
            'country' => $request->get('country'),
            'state' => $request->get('state'),
        ];

        $perPage = $request->get('per_page', 10);
        $rawCustomers = $this->customerRepository->list($perPage, $filters);

        $parsed = $this->phoneNumberService->parsePhones($rawCustomers->items());

        if (!empty($filters['state'])) {
            $parsed = $parsed->filter(function($item) use ($filters) {
                return $item['state'] === $filters['state'];
            })->values();
        }

        $customers = new \Illuminate\Pagination\LengthAwarePaginator(
            $parsed,
            $rawCustomers->total(),
            $rawCustomers->perPage(),
            $rawCustomers->currentPage(),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $countries = [
            ['code' => '237', 'name' => 'Cameroon'],
            ['code' => '251', 'name' => 'Ethiopia'],
            ['code' => '212', 'name' => 'Morocco'],
            ['code' => '258', 'name' => 'Mozambique'],
            ['code' => '256', 'name' => 'Uganda'],
        ];
        return view('customers.index', compact('customers', 'countries', 'filters'));
    }
}
