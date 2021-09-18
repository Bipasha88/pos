<?php

namespace App\Services\Vendor;

use App\BusinessObjects\Branch;
use App\BusinessObjects\Vendor;
use App\Repository\Vendor\IVendorRepository;
use App\Services\Branch\IBranchService;
use App\Utility\TableData;
use Illuminate\Support\Facades\DB;
use Exception;

class VendorService implements IVendorService{

    private $vendorRepository;
    private $branchService;

    public function __construct(IVendorRepository $vendorRepository, IBranchService $branchService){
        $this->vendorRepository = $vendorRepository;
        $this->branchService = $branchService;
    }

    public function createVendor(Vendor $vendor){
        $branches_id = $this->branchService->getBranchesId($vendor->branchesName);

        if($branches_id != null){
            $newVendor = $this->vendorRepository->create([
                'name' => $vendor->name,
                'address' => $vendor->address,
                'email' => $vendor->email,
                'phone' => $vendor->phone,
            ]);
            $newVendor->branches()->sync($branches_id);
            return $newVendor;
        }
        return null;
    }

    public function getVendors($businessId, $offset,
                               $limit, $search, $orderColumn, $direction) : TableData
    {
        $vendorBusinessObjects = [];
        $vendors = $this->vendorRepository->getPagedVendors($businessId,
            $offset, $limit, $search, $orderColumn, $direction);

            if ($vendors != null) {
                foreach ($vendors->data as $vendor) {
                    $vendorBusinessObject = new Vendor();
                    $vendorBusinessObject->id = $vendor->id;
                    $vendorBusinessObject->name = $vendor->name;
                    $vendorBusinessObject->address = $vendor->address;
                    $vendorBusinessObject->phone = $vendor->phone;
                    $vendorBusinessObject->email = $vendor->email;
                    $vendorBusinessObject->branch = $vendor->bname;

                    $vendorBusinessObjects[] = $vendorBusinessObject;
                }
            }

        return new TableData($vendorBusinessObjects,
            $vendors->recordsTotal, $vendors->recordsFiltered);
    }

    public function deleteVendorById($id){
        $this->vendorRepository->deleteById($id);
    }

    public function getVendorById($id){
        $vendor = $this->vendorRepository->with('branches')->find($id);
        $branchObjectes = [];

        foreach($vendor->branches as $branch){
            $branchObject = new Branch();
            $branchObject->name = $branch->name;
            $branchObject->id = $branch->id;

            $branchObjectes[] = $branchObject;
        }

        $vendorObject = new Vendor();
        $vendorObject->id = $vendor->id;
        $vendorObject->name = $vendor->name;
        $vendorObject->email = $vendor->email;
        $vendorObject->phone = $vendor->phone;
        $vendorObject->address = $vendor->address;
        $vendorObject->branchesName = $branchObjectes;
        return $vendorObject;
    }

    public function updateVendor($id, $vendor){
        $branches_id = $this->branchService->getBranchesId($vendor->branchesName);

         $this->vendorRepository->update($id, [
            'name' => $vendor->name,
            'address' => $vendor->address,
            'email' => $vendor->email,
            'phone' => $vendor->phone,
        ]);

        if($branches_id != null){
            $vendor = $this->vendorRepository->getById($id);
            $vendor->branches()->sync($branches_id);
        }
    }
}
