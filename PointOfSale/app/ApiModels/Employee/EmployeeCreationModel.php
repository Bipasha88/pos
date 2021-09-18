<?php

namespace App\ApiModels\Employee;

use App\Http\Requests\EmployeeCreateRequest;
use App\Services\Employee\IEmployeeService;
use Exception;

class EmployeeCreationModel
{
    private $employeeService;

    public function __construct(IEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function createEmployee(EmployeeCreateRequest $request,$customerId)
    {
        $employee = $request->getObject();
        return $this->employeeService->addEmployee($employee,$customerId);
    }
}
