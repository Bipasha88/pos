<?php

namespace App\Services\Branch;

use App\BusinessObjects\Branch;
use App\Utility\TableData;

interface IBranchService{
    public function createBranch(Branch $branch,$customerId);
    public function updateBranch($id, Branch $branch);
    public function getBranchById($id);
    public function deleteBranchById($id);
    public function getBranches($customerId, $offset, $limit, $search,
                                $orderColumn, $direction) : TableData;
    public function getSelectedBranch($branchName);
    public function getOwnedBranches($customerId);
    public function getBranchesId($branchesName);
}
