<?php

namespace App\Http\Requests;

use App\BusinessObjects\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'product_category_id' => 'required',
            'retail_price' => 'required',
            'whole_sale_price' => 'required',
            'business_id' => 'required',
        ];
    }

    public function getObject()
    {
        $product = new Product();
        $product->name = $this->request->get("name");
        $product->code = $this->request->get("code");
        $product->product_category = $this->request->get("product_category_id");
        $product->retail_price = $this->request->get("retail_price");
        $product->whole_sale_price = $this->request->get("whole_sale_price");
        $product->business_id = $this->request->get("business_id");

        return $product;
    }
}
