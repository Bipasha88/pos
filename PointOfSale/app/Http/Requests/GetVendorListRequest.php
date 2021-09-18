<?php

namespace App\Http\Requests;

use App\BusinessObjects\Vendor;
use Illuminate\Foundation\Http\FormRequest;

class GetVendorListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    public function getObject(){
        $vendor = new Vendor();
        $vendor->search = $this->request->get("search");
        $vendor->offset = $this->request->get("offset");
        $vendor->limit = $this->request->get("limit");
        $vendor->column = $this->request->get("order");
        $vendor->direction = $this->request->get("direction");
        return $vendor;
    }
}
