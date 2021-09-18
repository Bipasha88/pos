<?php

namespace App\Repository\Branch;

use App\Repository\Base\IBaseRepository;
use App\Utility\TableData;

interface IBranchRepository extends IBaseRepository {
    public function getPagedBranches($businessId, $offset, $limit, $search,
                                     $orderColumn, $direction) : TableData;
}
