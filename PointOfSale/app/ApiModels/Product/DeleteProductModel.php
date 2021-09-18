<?php

namespace App\ApiModels\Product;

use App\Services\Product\IProductService;

class DeleteProductModel
{
    private $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function deleteProduct($id)
    {
        return $this->productService->deleteProduct($id);
    }
}
