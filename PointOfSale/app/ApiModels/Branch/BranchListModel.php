<?php

namespace App\ApiModels\Branch;

use App\Http\Requests\CommonListRequest;
use App\Services\Branch\IBranchService;
use App\Utility\TableData;

class BranchListModel
{
    private $branchService;

    public function __construct(IBranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function getBranches($customerId, CommonListRequest $request): TableData
    {
        $commonList= $request->getObject();
        return $this->branchService->getBranches($customerId, $commonList->offset,
        $commonList->limit, $commonList->search, $commonList->order, $commonList->direction);
    }

    public function deleteBranch($id){
        return $this->branchService->deleteBranchById($id);
    }
}
