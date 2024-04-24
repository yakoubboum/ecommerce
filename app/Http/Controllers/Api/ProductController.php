<?php

namespace App\Http\Controllers\Api;


use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Requests\Products\CreateProductValidator;
use App\Requests\Products\ImportProductValidator;
use App\Requests\Products\UpdateProductValidator;
use App\Services\ProductsService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends BaseController
{
    public $productService;

    public function __construct(ProductsService $productService){
        $this->productService=$productService;
    }
    public function index(){
        return $this->productService->getProducts();
    }
    public function store(CreateProductValidator $createProductValidator){
        if(!empty($createProductValidator->getErrors())){
            return response()->json($createProductValidator->getErrors(),406);
        }
        $data=$createProductValidator->request()->all();
        $data['user_id']=Auth::user()->id;
        $response=$this->productService->createProduct($data);
        return $this->sendResponse($response);
    }
    public function update($id,UpdateProductValidator $updateProductValidator){
        if(!empty($updateProductValidator->getErrors())){
            return response()->json($updateProductValidator->getErrors(),406);
        }
        $data=$updateProductValidator->request()->all();
        $data['user_id']=Auth::user()->id;
        $response=$this->productService->updateProduct($id,$data);
        return $this->sendResponse($response);
    }
    public function destroy($id){
        $this->productService->deleteProduct($id);
        return $this->sendResponse("deleted Successfully");
    }

    public function export(){
        return Excel::download(new ProductsExport(), 'export1.xlsx');
    }
    public function import(ImportProductValidator $importProductValidator){
        if(!empty($importProductValidator->getErrors())){
            return response()->json($importProductValidator->getErrors(),406);
        }
        Excel::import(new ProductsImport(), $importProductValidator->request()->file('file')->store('files'));
        return $this->sendResponse("Saved");
    }
}
