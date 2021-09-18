<?php

namespace App\ApiModels\Product;

use App\Http\Requests\CommonListRequest;
use App\Services\Product\IProductService;
use App\Utility\TableData;

class ProductListModel
{
    private $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts($customerId, CommonListRequest $request): TableData
    {
        $data = $request->getObject();
        return $this->productService->getProducts($customerId, $data->offset, $data->limit,
                                                        $data->search, $data->order, $data->direction);
    }
}
