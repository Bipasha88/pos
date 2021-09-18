<?php

namespace App\Repository\Vendor;

use App\Models\Vendor;
use App\Repository\Base\BaseRepository;
use App\Utility\TableData;
use Illuminate\Support\Facades\DB;

class VendorRepository extends BaseRepository implements IVendorRepository
{

    public function __construct(Vendor $model)
    {
        parent::__construct($model);
    }

    public function getPagedVendors($businessId, $offset, $limit, $search,
                                    $orderColumn, $direction) : TableData
    {
        $vendorsQuery = DB::table('vendors')
            ->select('vendors.*', 'branches.name as bname')
            ->join('branch_vendor', 'vendors.id', '=', 'branch_vendor.vendor_id')
            ->join('branches', function ($join) use ($businessId, $search) {
                $join->on('branch_vendor.branch_id', '=', 'branches.id')
                ->where('branches.business_id', '=', $businessId );
            });
        $total = $vendorsQuery->count();

        if($search != null)
        {
            $vendorsQuery = DB::table('vendors')
                ->select('vendors.*', 'branches.name as bname')
                ->join('branch_vendor', 'vendors.id', '=', 'branch_vendor.vendor_id')
                ->join('branches', function ($join) use ($businessId, $search) {
                    $join->on('branch_vendor.branch_id', '=', 'branches.id')
                        ->where('branches.business_id', '=', $businessId )
                        ->where('vendors.name', 'LIKE','%'.$search.'%');
                });
        }
        $totalDisplay = $vendorsQuery->count();

        $rows = $vendorsQuery
            ->orderBy($orderColumn, $direction)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return new TableData($rows, $total, $totalDisplay);
    }
}
