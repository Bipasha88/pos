<?php

namespace App\ApiModels\Category;

use App\Services\Category\ICategoryService;

class GetCategoryModel {
    private $categoryService;

    public function __construct(ICategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    public function getCategory($id){
        return $this->categoryService->getCategoryById($id);
    }
}
