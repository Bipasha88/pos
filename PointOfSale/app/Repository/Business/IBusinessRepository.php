<?php

namespace App\Repository\Business;

use App\Repository\Base\IBaseRepository;
use App\Utility\TableData;

interface IBusinessRepository extends IBaseRepository
{
    public function getBusinessByName($name);
    public function businessesByUserId($id);
    public function getPagedBusinesses($offset, $limit, $search, 
        $orderColumn, $direction) : TableData;
}
