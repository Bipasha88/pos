<?php

namespace App\Repository\Business;

use App\Models\Business;
use App\Repository\Base\BaseRepository;
use App\Utility\TableData;

class BusinessRepository extends BaseRepository implements IBusinessRepository
{

    public function __construct(Business $model)
    {
        parent::__construct($model);
    }

    public function getBusinessByName($name)
    {
        return $this->model->where(['name' => $name])->get();
    }

    public function businessesByUserId($id)
    {
        return $this->model->where(['user_id' => $id])->get();
    }

    public function getPagedBusinesses($offset, $limit, $search, 
        $orderColumn, $direction) : TableData
    {
        $businessQuery = $this->model;
        $total = $this->count();

        if($search != null)
        {
            $businessQuery = $businessQuery->where('name','LIKE','%'.$search.'%');
        }
        $totalDisplay = $businessQuery->count();

        $rows = $businessQuery
            ->orderBy($orderColumn, $direction)
            ->offset($offset)
            ->limit($limit)
            ->get();

        return new TableData($rows, $total, $totalDisplay);
    }
}
