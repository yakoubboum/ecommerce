<?php
namespace App\Requests\Products;

use App\Requests\BaseRequestFormApi;

class UpdateProductValidator extends BaseRequestFormApi {
    public function rules(): array
    {
        $id=$this->request()->segment(3);
        return [
            'title'=>'required|min:3|max:50|unique:products,title,'.$id.',id',
            'description'=>'required|min:3|max:1000',
            'size'=>'required|numeric|min:30|max:100',
            'color'=>'required|in:red,green',
            'price'=>'nullable|numeric|min:1|max:10000',
        ];
    }

    public function authorized(): bool
    {
        return true;
    }
}
