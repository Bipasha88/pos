<?php

namespace App\Services\Branch;

use App\BusinessObjects\Branch;
use App\Repository\Branch\IBranchRepository;
use App\Repository\Business\IBusinessRepository;
use App\Services\Business\IBusinessService;
use App\Utility\TableData;
use Exception;
use Illuminate\Support\Facades\DB;

class BranchService implements IBranchService{

    private $branchRepo;
    private $businessService;

    public function __construct(IBranchRepository $branchRepository,
                                 IBusinessService $businessService){
        $this->branchRepo = $branchRepository;
        $this->businessService = $businessService;
    }

    public function createBranch(Branch $branch,$customerId){

        $business = $this->businessService->getOwnedBusiness($customerId);
        $businessId = 0;

        if($business != null)
            $businessId = $business->id;

        $newBranch = $this->branchRepo->create([
            'name' => $branch->name,
            'address' => $branch->address,
            'email' => $branch->email,
            'phone' => $branch->phone,
            'business_id' => $businessId
        ]);
        return $newBranch;
    }

    public function getBranches($customerId, $offset, $limit, $search,
                                 $orderColumn, $direction) : TableData
    {
        $branchBusinessObjects = [];
        $business = $this->businessService->getOwnedBusiness($customerId);
        $businessId = 0;

        if($business != null)
            $businessId = $business->id;

        $branches = $this->branchRepo->getPagedBranches($businessId,
            $offset, $limit, $search, $orderColumn, $direction);

        if($branches != null)
        {
            foreach($branches->data as $branch)
            {
                $branchBusinessObject = new Branch();
                $branchBusinessObject->id = $branch->id;
                $branchBusinessObject->name = $branch->name;
                $branchBusinessObject->address = $branch->address;
                $branchBusinessObject->phone = $branch->phone;
                $branchBusinessObject->email = $branch->email;
                $branchBusinessObject->business_id = $branch->business_id;

                $branchBusinessObjects[] = $branchBusinessObject;
            }
        }

        return new TableData($branchBusinessObjects,
            $branches->recordsTotal, $branches->recordsFiltered);
    }

    public function updateBranch($id, Branch $branch){
        try {
            return $this->branchRepo->update($id, [
                'name' => $branch->name,
                'address' => $branch->address,
                'email' => $branch->email,
                'phone' => $branch->phone,
            ]);
        }
        catch (Exception $exception){
            throw new Exception( "Cannot create Branch");
        }
    }

    public function getBranchById($id){
        try {
            return $this->branchRepo->getById($id);
        }
        catch (Exception $exception){
            throw new Exception("Cannot get the branch");
        }
    }

    public function deleteBranchById($id){
        try {
            return $this->branchRepo->deleteById($id);
        }
        catch (Exception $exception){
            throw new Exception("Cannot delete the branch");
        }
    }

    public function getSelectedBranch($branchName){
        $branch = $this->branchRepo->where('name', $branchName)->first();
        return $branch;
    }

    public function getOwnedBranches($businessId)
    {
        $branches = $this->branchRepo->with("vendors")->where('business_id', $businessId)
            ->get();
        if ($branches != null)
            return $branches;
        else
            throw new Exception("Don't Have any Branch");
    }

    public function getBranchesId($branchesNameJson){
        $braches_id = array();
        $branchesNameString = json_encode($branchesNameJson);
        $branchesName = json_decode($branchesNameString,true);

        if($branchesName!=null) {
            foreach ($branchesName as $branchName) {
                $search = $this->branchRepo->where("name", $branchName['name'])->first()->id;

                array_push($braches_id, $search);
            }
            return $braches_id;
        }
        return null;
    }
}
