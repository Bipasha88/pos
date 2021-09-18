<?php

namespace App\ApiModels\Vendor;

use App\BusinessObjects\Branch;
use App\Services\Branch\IBranchService;

class OwnedBranchListModel{
    private $branchService;

    public function __construct(IBranchService $branchService){
        $this->branchService = $branchService;
    }

    public function ownedBranchesList($customer){
        if($customer != null) {
            $branchObjectes = [];
            $businessId = $customer->businesses()->first()->id;
            $branches = $this->branchService->getOwnedBranches($businessId);

            foreach ($branches as $branch) {
                $branchObject = new Branch();
                $branchObject->name = $branch->name;
                $branchObject->id = $branch->id;

                $branchObjectes[] = $branchObject;
            }

            return $branchObjectes;
        }
        throw new \Exception("Don't have any customer");
    }
}
