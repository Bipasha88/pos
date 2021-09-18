<?php

namespace App\ApiModels\Category;

use App\Http\Requests\CommonListRequest;
use App\Services\Category\ICategoryService;
use App\Utility\TableData;

class CategoryListModel
{
    private $categoryService;

    public function __construct(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getCategories($customerId,CommonListRequest $request ): TableData
    {
        $commonList= $request->getObject(); 
        return $this->categoryService->getCategories($customerId, $commonList->offset,
        $commonList->limit, $commonList->search, $commonList->order, $commonList->direction);
    }

    public function deleteCategory($id){
        return $this->categoryService->deleteCategoryById($id);
    }
}

