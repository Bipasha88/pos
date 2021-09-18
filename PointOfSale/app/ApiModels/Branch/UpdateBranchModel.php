<?php

namespace App\ApiModels\Branch;

use App\Http\Requests\UpdateBranchRequest;
use App\Services\Branch\IBranchService;

class UpdateBranchModel {
    private $branchService;

    public function __construct(IBranchService $branchService){
        $this->branchService = $branchService;
    }

    public function updateBranch($id, UpdateBranchRequest $request){
        $branch = $request->getObject();
        $this->branchService->updateBranch($id, $branch);
    }
}
