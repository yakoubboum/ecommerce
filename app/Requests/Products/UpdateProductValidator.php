<?php
namespace App\Requests\Products;

use App\Requests\BaseRequestFormApi;

class UpdateProductValidator extends BaseRequestFormApi {
    public function rules(): array
    {
        $id=$this->request()->segment(3);
        return [
            'name' => 'required|string|max:255|unique:products,name,'.$id.',id',
            'section_id' => 'required|integer|exists:sections,id',
            'price' => 'required|numeric|min:0.01',
            'discount' => 'nullable|integer|min:0|max:100',
            'delivery_price' => 'nullable|numeric|min:0',
            'delivery_time' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function authorized(): bool
    {
        return true;
    }
}
