<?php

namespace App\Services\Product;

use Exception;
use App\Utility\TableData;
use App\BusinessObjects\Product;
use App\Repository\Business\IBusinessRepository;
use Illuminate\Support\Facades\DB;
use App\Services\Business\IBusinessService;
use App\Repository\Product\IProductRepository;
use App\Services\Category\ICategoryService;

class ProductService implements IProductService
{
    private $productRepository;
    private $businessRepository;
    public $businessService;
    public $categoryService;

    public function __construct(IProductRepository $productRepository, IBusinessService $businessService,
                                    ICategoryService $categoryService, IBusinessRepository $businessRepository)
    {

        $this->productRepository = $productRepository;
        $this->businessService = $businessService;
        $this->categoryService = $categoryService;
        $this->businessRepository = $businessRepository;
    }

    public function getProducts($customerId, $offset, $limit, $search, $orderColumn, $direction) : TableData
    {
        $productBusinessObjects = [];
        $business = $this->businessService->getOwnedBusiness($customerId);
        $products = $this->productRepository->getPagedProducts($business->id, $offset, $limit, $search, $orderColumn, $direction);

        if($products != null)
        {
            foreach($products->data as $product)
            {
                $productBusinessObject = new Product();
                $productBusinessObject->id = $product->id;
                $productBusinessObject->name = $product->name;
                $productBusinessObject->code = $product->code;
                $productBusinessObject->product_category = $this->categoryService->getCategoryById($product->product_category_id)->name;
                $productBusinessObject->retail_price = $product->retail_price;
                $productBusinessObject->whole_sale_price = $product->whole_sale_price;
                $productBusinessObject->business_id = $product->business_id;

                $productBusinessObjects[] = $productBusinessObject;
            }
        }

        return new TableData($productBusinessObjects, $products->recordsTotal, $products->recordsFiltered);
    }

    public function createProduct(Product $product)
    {
       if( count($this->productRepository->getProductByName(['name' => $product->name])) == 0)
       {
            return $this->productRepository->create([
                'name' => $product->name,
                'code' => $product->code,
                'product_category_id' => $this->categoryService->getCategoryByName($product->product_category)->id,
                'retail_price' => $product->retail_price,
                'whole_sale_price' => $product->whole_sale_price,
                'business_id' => $this->businessService->getBusinessByName($product->business_id)->id,
            ]);
        }
        else
        {
            throw new Exception("Can not create product", 1);
        }
    }

    public function getProduct($id)
    {
        return $this->productRepository->find($id);
    }

    public function updateProduct(Product $product, $id)
    {
        if ($product->product_category != null)
        {
            return $this->productRepository->update($id, [
                'name' => $product->name,
                'code' => $product->code,
                'retail_price' => $product->retail_price,
                'whole_sale_price' => $product->whole_sale_price,
                'product_category_id' => $this->categoryService->getCategoryByName($product->product_category)->id
            ]);
        }
        else
        {
            return $this->productRepository->update($id, [
                'name' => $product->name,
                'code' => $product->code,
                'retail_price' => $product->retail_price,
                'whole_sale_price' => $product->whole_sale_price,
            ]);
        }
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->destroy($id);
    }

    public function getAllCategory()
    {
        $categories = $this->categoryService->getAll();

        return $categories;
    }

    public function businessesByUserId($id)
    {
        return $this->businessRepository->businessesByUserId($id);
    }
}
