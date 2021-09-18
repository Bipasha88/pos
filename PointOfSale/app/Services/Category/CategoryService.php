<?php

namespace App\Services\Category;

use App\BusinessObjects\Category;
use App\Repository\Category\ICategoryRepository;
use App\Services\Business\IBusinessService;
use App\Utility\TableData;

class CategoryService implements ICategoryService{

    private $categoryRepository;
    private $businessService;

    public function __construct(ICategoryRepository $categoryRepository,
                                 IBusinessService $businessService){
        $this->categoryRepository = $categoryRepository;
        $this->businessService = $businessService;
    }

    public function createCategory(Category $category,$customerId){

        $business = $this->businessService->getOwnedBusiness($customerId);
        $businessId = 0;

        if($business != null)
            $businessId = $business->id;

        $newCategory = $this->categoryRepository->create([
            'name' => $category->name,
            'business_id' => $businessId
        ]);
        return $newCategory;
    }

    public function getCategories($customerId, $offset, $limit, $search,
                                 $orderColumn, $direction) : TableData
    {
        $categoryBusinessObjects = [];
        $business = $this->businessService->getOwnedBusiness($customerId);
        $businessId = 0;

        if($business != null)
            $businessId = $business->id;

        $categories = $this->categoryRepository->getPagedCategories($businessId,
            $offset, $limit, $search, $orderColumn, $direction);

        if($categories != null)
        {
            foreach($categories->data as $category)
            {
                $categoryBusinessObject = new Category();
                $categoryBusinessObject->id = $category->id;
                $categoryBusinessObject->name = $category->name;
                $categoryBusinessObjects[] = $categoryBusinessObject;
            }
        }

        return new TableData($categoryBusinessObjects,
            $categories->recordsTotal, $categories->recordsFiltered);
    }

    public function updateCategory($id, Category $category){
        return $this->categoryRepository->update($id, [
            'name' => $category->name,
        ]);
    }

    public function getCategoryById($id){
        return $this->categoryRepository->getById($id);
    }

    public function deleteCategoryById($id){
        return $this->categoryRepository->deleteById($id);
    }

    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function getCategoryByName($name)
    {
        return $this->categoryRepository->getCategoryByName($name)->first();
    }
}
