<?php

namespace App\Repository\Employee;

use App\Repository\Base\IBaseRepository;
use App\Utility\TableData;

interface IEmployeeRepository extends IBaseRepository {
    public function getPagedEmployees($businessId, $offset, $limit, 
        $search, $orderColumn, $direction) : TableData;
}
