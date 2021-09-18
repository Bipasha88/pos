<?php

namespace App\Http\Requests;

use App\BusinessObjects\Vendor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'email',
        ];
    }
    public function getObject(){
        $vendor = new Vendor();
        $vendor->id = $this->request->get('id');
        $vendor->name = $this->request->get('name');
        $vendor->address = $this->request->get('address');
        $vendor->phone = $this->request->get('phone');
        $vendor->email = $this->request->get('email');
        $vendor->branchesName = $this->request->get('branches');
        return $vendor;
    }
}
