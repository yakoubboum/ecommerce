<?php
namespace App\Requests\Products;

use App\Requests\BaseRequestFormApi;

class CreateProductValidator extends BaseRequestFormApi {
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'section_id' => 'required|integer|exists:sections,id',
            'price' => 'required|numeric|min:0.01',
            'discount' => 'nullable|integer|min:0|max:100',
            'delivery_price' => 'nullable|numeric|min:0',
            'delivery_time' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
        ];
    }

    public function authorized(): bool
    {
        return true;
    }
}
