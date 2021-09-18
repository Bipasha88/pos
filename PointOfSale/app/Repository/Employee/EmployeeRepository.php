<?php

namespace App\Repository\Employee;

use App\Models\Employee;
use App\Repository\Base\BaseRepository;
use App\Utility\TableData;

class EmployeeRepository extends BaseRepository implements IEmployeeRepository {

    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function getPagedEmployees($businessId, $offset, $limit, $search, 
        $orderColumn, $direction) : TableData
    {
        $employeesQuery = $this->where('business_id', $businessId);
        $total = $employeesQuery->count();

        if($search != null)
        {
            $employeesQuery = $employeesQuery->where('name','LIKE','%'.$search.'%');
        }
        $totalDisplay = $employeesQuery->count();

        $rows = $employeesQuery
            ->orderBy($orderColumn, $direction)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return new TableData($rows, $total, $totalDisplay);
    }
}
