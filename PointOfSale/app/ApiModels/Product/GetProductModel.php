<?php

namespace App\ApiModels\Product;

use App\Services\Product\IProductService;

class GetProductModel
{
    private $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProduct($id)
    {
        return $this->productService->getProduct($id);
    }
}
