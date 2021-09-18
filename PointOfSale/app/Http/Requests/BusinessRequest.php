<?php

namespace App\Http\Requests;

use App\BusinessObjects\Business;
use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
            'email' => 'required',
            'website' => 'required',
        ];
    }

    public function getObject(){
        $business = new Business();
        $business->id = $this->request->get('id');
        $business->name = $this->request->get('name');
        $business->address = $this->request->get('address');
        $business->phone = $this->request->get('phone');
        $business->email = $this->request->get('email');
        $business->website = $this->request->get('website');
        return $business;
    }
}
