<?php

namespace App\Repository\Branch;

use App\Models\Branch;
use App\Repository\Base\BaseRepository;
use App\Utility\TableData;

class BranchRepository extends BaseRepository implements IBranchRepository {

    public function __construct(Branch $model)
    {
        parent::__construct($model);
    }

    public function getPagedBranches($businessId, $offset, $limit, $search,
                                     $orderColumn, $direction) : TableData
    {
        $branchesQuery = $this->where('business_id', $businessId);
        $total = $branchesQuery->count();

        if($search != null)
        {
            $branchesQuery = $branchesQuery->where('name','LIKE','%'.$search.'%');
        }
        $totalDisplay = $branchesQuery->count();

        $rows = $branchesQuery
            ->orderBy($orderColumn, $direction)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return new TableData($rows, $total, $totalDisplay);
    }
}
