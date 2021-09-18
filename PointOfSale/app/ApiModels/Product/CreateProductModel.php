<?php
namespace App\ApiModels\Product;

use Illuminate\Support\Facades\Auth;
use App\Services\Product\ProductService;
use App\Services\Product\IProductService;
use App\Services\Business\BusinessService;
use App\Http\Requests\CreateProductRequest;
use App\Services\Business\IBusinessService;

class CreateProductModel
{
    private $productService;
    public $businessService;

    public function __construct(IProductService $productService, IBusinessService $businessService)
    {
        $this->productService = $productService;
        $this->businessService = $businessService;
    }

    public function createProduct(CreateProductRequest $request)
    {
        $product = $request->getObject();

        return $this->productService->createProduct($product);
    }

    public function getOwenedBusiness($id)
    {
        return $this->productService->businessesByUserId($id);
    }
}
