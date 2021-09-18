<?php

namespace App\ApiModels\Employee;

use App\Http\Requests\CommonListRequest;
use App\Services\Employee\IEmployeeService;
use App\Utility\TableData;

class EmployeeListModel
{
    private $employeeService;

    public function __construct(IEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function getEmployees($customerId, CommonListRequest $request): TableData
    {
        $commonList= $request->getObject();
        return $this->employeeService->getEmployees($customerId, $commonList->offset,
        $commonList->limit, $commonList->search, $commonList->order, $commonList->direction);
    }

    public function deleteEmployee($id)
    {
        return $this->employeeService->deleteEmployee($id);
    }
}
