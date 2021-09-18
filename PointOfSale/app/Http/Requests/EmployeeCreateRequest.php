<?php

namespace App\Http\Requests;

use App\BusinessObjects\Employee;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeCreateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function passesAuthorization()
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
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|unique:employees',
            'email' => 'required|string|email|max:255|unique:employees',
        ];
    }

    public function getObject()
    {
        $employee = new Employee();
        $employee->name = $this->request->get('name');
        $employee->address = $this->request->get('address');
        $employee->phone = $this->request->get('phone');
        $employee->email = $this->request->get('email');

        return $employee;
    }
}
