<?php

namespace App\Repository\Category;

use App\Repository\Base\IBaseRepository;
use App\Utility\TableData;

interface ICategoryRepository extends IBaseRepository
{
    public function getCategoryByName($name);
    public function getPagedCategories($businessId, $offset, $limit, $search,
                                     $orderColumn, $direction) : TableData;
}
