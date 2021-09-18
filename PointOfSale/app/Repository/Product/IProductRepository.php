<?php

namespace App\Repository\Product;

use App\Utility\TableData;
use App\Repository\Base\IBaseRepository;

interface IProductRepository extends IBaseRepository
{
    public function getPagedProducts($businessId, $offset, $limit, $search, $orderColumn, $direction) : TableData;
    public function getProductByName($attributes);
}
