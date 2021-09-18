<?php

namespace App\Repository\Vendor;

use App\Repository\Base\IBaseRepository;
use App\Utility\TableData;

interface IVendorRepository extends IBaseRepository{
    public function getPagedVendors($businessId, $offset, $limit, $search,
                                    $orderColumn, $direction) : TableData;
}
