<?php

namespace App\ApiModels\Branch;

use App\Http\Requests\CreateBranchRequest;
use App\Services\Branch\IBranchService;

class CreateBranchModel {
    private $branchService;

    public function __construct(IBranchService $branchService){
        $this->branchService = $branchService;
    }

    public function createBranch(CreateBranchRequest $request,$customerId){
        $branch = $request->getObject();
        return $this->branchService->createBranch($branch,$customerId);
    }
}
