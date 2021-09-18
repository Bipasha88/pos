<?php

namespace App\ViewModels\User;

use App\Http\Requests\CustomerCreateRequest;
use App\Services\Email\IEmailService;
use App\Services\IMembershipService;

class RegisterCustomerModel {
    private $membershipService;
    public $customer;
    public $subject;
    public $body;

    public function __construct(IMembershipService $membershipService) {
        $this->membershipService = $membershipService;
    }

    public function createCustomer(CustomerCreateRequest $request) {
        $customer = $request->getObject();
        $businessName = $customer->businessName;
        $email = $customer->email;
        $password = $customer->password;
        $this->customer = $this->membershipService->CreateCustomer($businessName, $email, $password);
    }
}
