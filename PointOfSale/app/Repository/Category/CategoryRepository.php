<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\Base\BaseRepository;
use App\Utility\TableData;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getPagedCategories($businessId, $offset, $limit, $search,
                                     $orderColumn, $direction) : TableData
    {
        $categoriesQuery = $this->where('business_id', $businessId);
        $total = $categoriesQuery->count();

        if($search != null)
        {
            $categoriesQuery = $categoriesQuery->where('name','LIKE','%'.$search.'%');
        }
        $totalDisplay = $categoriesQuery->count();

        $rows = $categoriesQuery
            ->orderBy($orderColumn, $direction)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return new TableData($rows, $total, $totalDisplay);
    }

    public function getCategoryByName($name)
    {
        return $this->model->where(['name' => $name])->get();
    }

    public function categoriesByBusinessId($id)
    {
        return $this->model->where(['business_id' => $id])->get();
    }
}
