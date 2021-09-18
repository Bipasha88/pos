<?php

namespace App\Repository\Product;

use App\Models\Product;
use App\Utility\TableData;
use App\Repository\Base\BaseRepository;

class ProductRepository extends BaseRepository implements IProductRepository
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getPagedProducts($businessId, $offset, $limit, $search, $orderColumn, $direction) : TableData
    {
        $productsQuery = $this->where('business_id', $businessId);
        $total = $productsQuery->count();

        if($search != null)
        {
            $productsQuery = $productsQuery->where('name','LIKE','%'.$search.'%');
        }
        $totalDisplay = $productsQuery->count();

        $rows = $productsQuery
            ->orderBy($orderColumn, $direction)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return new TableData($rows, $total, $totalDisplay);
    }

    public function getProductByName($attributes)
    {
        return $this->model->where($attributes)->get();
    }
}
