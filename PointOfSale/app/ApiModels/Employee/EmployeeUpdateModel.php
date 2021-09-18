<?php

namespace App\ApiModels\Employee;

use Illuminate\Http\Request;
use App\Services\Employee\IEmployeeService;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeUpdateModel
{
    private $employeeService;

    public function __construct(IEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function updateEmployee(UpdateEmployeeRequest $request, $id)
    {
        $employee = $request->getObject();

        return $this->employeeService->editEmployee($employee, $id);
    }

    public function getEmployee($id)
    {
        return $this->employeeService->getEmployee($id);
    }
}
