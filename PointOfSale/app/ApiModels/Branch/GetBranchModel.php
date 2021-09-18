<?php

namespace App\ApiModels\Branch;

use App\Services\Branch\IBranchService;

class GetBranchModel {
    private $branchService;

    public function __construct(IBranchService $branchService){
        $this->branchService = $branchService;
    }

    public function getBranch($id){
        return $this->branchService->getBranchById($id);
    }
}
