<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\ProductRepositoryInterface;


class ProductController extends Controller
{
    protected $Product;

    public function __construct(ProductRepositoryInterface $Product)
    {
        $this->Product = $Product;
    }


    public function index()
    {
        return $this->Product->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        return $this->Product->store($r);
    }


    public function update(Request $request, $id)
    {
        
        return $this->Product->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        return $this->Product->destroy($id);
    }
}
