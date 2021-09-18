<?php

namespace App\Services\Employee;

use App\Utility\TableData;
use Illuminate\Http\Request;
use App\BusinessObjects\Employee;

interface IEmployeeService
{
    public function getEmployees($customerId, $offset, $limit,
        $search, $orderColumn, $direction) : TableData;

    public function addEmployee(Employee $employee,$customerId);

    public function deleteEmployee($id);

    public function archiveEmployee($id);

    public function getBusinessList();

    public function getEmployee($id);

    public function editEmployee(Employee $employee, $id);
}
