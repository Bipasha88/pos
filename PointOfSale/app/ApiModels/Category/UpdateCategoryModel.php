<?php

namespace App\ApiModels\Category;

use App\Http\Requests\UpdateCategoryRequest;
use App\Services\Category\ICategoryService;

class UpdateCategoryModel {
    private $categoryService;

    public function __construct(ICategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    public function updateCategory($id, UpdateCategoryRequest $request){
        $category = $request->getObject();
        $this->categoryService->updateCategory($id, $category);
    }
}
