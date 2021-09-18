<?php

namespace App\Http\Requests;

use App\BusinessObjects\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'code' => 'required',
            'retail_price' => 'required',
            'whole_sale_price' => 'required',
        ];
    }

    public function getObject()
    {
        $product = new Product();
        $product->name = $this->request->get("name");
        $product->code = $this->request->get("code");
        $product->retail_price = $this->request->get("retail_price");
        $product->whole_sale_price = $this->request->get("whole_sale_price");
        $product->product_category = $this->request->get("product_category");

        return $product;
    }
}
