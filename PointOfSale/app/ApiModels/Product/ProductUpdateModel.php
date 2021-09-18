<?php
namespace App\ApiModels\Product;

use App\Services\Product\IProductService;
use App\Http\Requests\UpdateProductRequest;

class ProductUpdateModel
{
    private $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
        $product = $request->getObject();
        return $this->productService->updateProduct($product, $id);
    }

    public function getAllCategories()
    {
        return $this->productService->getAllCategory();
    }
}
