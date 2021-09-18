<?php

namespace App\Services\Employee;

use Mockery\Exception;
use App\Utility\ILogger;
use App\Utility\TableData;
use Illuminate\Http\Request;
use App\BusinessObjects\Employee;
use App\Services\Business\IBusinessService;
use App\Repository\Employee\IEmployeeRepository;
use Illuminate\Database\Eloquent\Collection;

class EmployeeService implements IEmployeeService
{
    private $employeeRepository;
    private $businessService;

    public function __construct(IEmployeeRepository $employeeRepository, IBusinessService $businessService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->businessService = $businessService;
    }

    public function getEmployees($customerId, $offset, $limit, $search, $orderColumn, $direction): TableData
    {
        $employeeBusinessObjects = [];
        $business = $this->businessService->getOwnedBusiness($customerId);
        $businessId = 0;

        if ($business != null)
            $businessId = $business->id;

        $employees = $this->employeeRepository->getPagedEmployees($businessId,
            $offset, $limit, $search, $orderColumn, $direction);

        if ($employees != null) {
            foreach ($employees->data as $employee) {
                $employeeBusinessObject = new Employee();
                $employeeBusinessObject->id = $employee->id;
                $employeeBusinessObject->name = $employee->name;
                $employeeBusinessObject->address = $employee->address;
                $employeeBusinessObject->phone = $employee->phone;
                $employeeBusinessObject->email = $employee->email;
                $employeeBusinessObject->business_id = $employee->business_id;

                $employeeBusinessObjects[] = $employeeBusinessObject;
            }
        }

        return new TableData($employeeBusinessObjects,
            $employees->recordsTotal, $employees->recordsFiltered);
    }

    public function addEmployee(Employee $employee,$customerId)
    {
        $business = $this->businessService->getOwnedBusiness($customerId);

        if($business != null) {
            $businessId = $business->id;

            $newEmployee = $this->employeeRepository->create([
                'name' => $employee->name,
                'address' => $employee->address,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'business_id' => $businessId
            ]);
            return $newEmployee;
        }
        else{
            throw new Exception("Don't have any business");
        }
    }

    public function deleteEmployee($id)
    {
        $this->employeeRepository->deleteById($id);
    }

    public function archiveEmployee($id)
    {
        $employee = $this->employeeRepository->find($id);
        $employee->status = 'archived';
        $employee->save();
    }

    /**
     * @return Collection
     */
    public function getBusinessList()
    {
        return request()->user()->businesses()->get(['id', 'name']);
    }

    public function editEmployee(Employee $employee, $id)
    {
        return $this->employeeRepository->update($id, [
            'name' => $employee->name,
            'address' => $employee->address,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'business_id' => $employee->business_id,
            'updated_at' => now(),
        ]);
    }

    public function getEmployee($id)
    {
        $employee = $this->employeeRepository->find($id);

        return $employee;
    }
}
