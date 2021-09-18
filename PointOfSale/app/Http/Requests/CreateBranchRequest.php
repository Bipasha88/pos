<?php

namespace App\Http\Requests;

use App\BusinessObjects\Branch;
use Illuminate\Foundation\Http\FormRequest;

class CreateBranchRequest extends FormRequest
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
            'name' => 'required|unique:branches',
            'address' => 'required',
            'phone' => 'required|unique:branches',
            'email' => 'email',
        ];
    }

    public function getObject(){
        $branch = new Branch();
        $branch->id = $this->request->get('id');
        $branch->name = $this->request->get('name');
        $branch->address = $this->request->get('address');
        $branch->businessName = $this->request->get('businessName');
        $branch->phone = $this->request->get('phone');
        $branch->email = $this->request->get('email');
        return $branch;
    }
}
