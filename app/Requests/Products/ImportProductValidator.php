<?php
namespace App\Requests\Products;

use App\Requests\BaseRequestFormApi;

class ImportProductValidator extends BaseRequestFormApi {
    public function rules(): array
    {
        return [
            'file'=>'required|mimes:csv,xlsx|max:8162',
        ];
    }

    public function authorized(): bool
    {
        return true;
    }
}
