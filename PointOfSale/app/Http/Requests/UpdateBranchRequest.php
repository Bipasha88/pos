<?php

namespace App\Http\Requests;

use App\BusinessObjects\Branch;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
        $branch = new Branch();
        $branch->name = $this->request->get('name');
        $branch->address = $this->request->get('address');
        $branch->phone = $this->request->get('phone');
        $branch->email = $this->request->get('email');
        return $branch;
    }
}
