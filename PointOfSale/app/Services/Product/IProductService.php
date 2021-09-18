<?php

namespace App\Services\Product;

use App\Utility\TableData;
use App\BusinessObjects\Product;

interface IProductService
{
    public function getProducts($customerId, $offset, $limit, $search, $orderColumn, $direction) : TableData;
    public function createProduct(Product $product);
    public function getProduct($id);
    public function updateProduct(Product $product, $id);
    public function deleteProduct($id);
    public function getAllCategory();
    public function businessesByUserId($id);
}
