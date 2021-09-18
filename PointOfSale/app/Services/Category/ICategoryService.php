<?php

namespace App\Services\Category;

use App\BusinessObjects\Category;
use App\Utility\TableData;

interface ICategoryService{
    public function getCategoryByName($name);
    public function getAll();
    public function createCategory(Category $category,$customerId);
    public function updateCategory($id, Category $branch);
    public function getCategoryById($id);
    public function deleteCategoryById($id);
    public function getCategories($productId, $offset, $limit, $search,
                                $orderColumn, $direction) : TableData;
}
