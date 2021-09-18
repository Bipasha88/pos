<?php

namespace App\ViewModels\Business;

use App\Services\Business\IBusinessService;
use Illuminate\Http\Request;

class BusinessesListModel {
    private $businessService;
    private $businesses;

    public function getbusinesses(){
        return $this->businesses;
    }

    public function __construct(IBusinessService $businessService){
        $this->businessService = $businessService;
    }

    public function load(){
        $this->businesses = $this->businessService->getAllBusinesses();
    }

    public function getbusinessesItems(Request $request){

        $columns = ['name', 'address', 'phone', 'email', 'website', 'user_id','archive'];

        $start = ((int)$request->get('start'));
        $length = ((int)$request->get('length'));
        $order = $request->get('order');
        $search = $request->get('search');

        $sortColumn = $columns[((int)$order[0]["column"])];

        $businesses = $this->businessService->getbusinesses($start, $length,
            $search["value"], $sortColumn, $order[0]["dir"]);


        $data = (object)array(
            'recordsTotal' => $businesses->recordsTotal,
            'recordsFiltered' => $businesses->recordsFiltered,
            'data' => []
        );

        foreach($businesses->data as $business)
        {
            $data->data[] = [$business->name,
            $business->address, $business->phone, $business->email,
            $business->website,$business->owner,  $business->status." ".((string)$business->id), ((string)$business->id)];
        }

        return $data;
    }
}
