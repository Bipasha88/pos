<?php

namespace App\Http\Requests;

use App\BusinessObjects\Employee;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'business_id' => 'required',
        ];
    }

    public function getObject(){
        $employee = new Employee();
        $employee->name = $this->request->get('name');
        $employee->address = $this->request->get('address');
        $employee->phone = $this->request->get('phone');
        $employee->email = $this->request->get('email');
        $employee->business_id = $this->request->get('business_id');

        return $employee;
    }
}
