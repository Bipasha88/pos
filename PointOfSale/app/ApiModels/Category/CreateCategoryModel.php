<?php

namespace App\ApiModels\Category;

use App\Http\Requests\CreateCategoryRequest;
use App\Services\Category\ICategoryService;

class CreateCategoryModel {
    private $categoryService;

    public function __construct(ICategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    public function createcategory(CreateCategoryRequest $request,$customerId){
        $category = $request->getObject();
        return $this->categoryService->createCategory($category,$customerId);
    }
}
