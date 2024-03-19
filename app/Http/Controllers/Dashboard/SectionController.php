<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreSectionRequest;
use App\Repository\SectionRepositoryInterface;

class SectionController extends Controller
{
    protected $Section;

    public function __construct(SectionRepositoryInterface $Section)
    {
        $this->Section = $Section;
    }

    public function index()
    {
        return $this->Section->index();
    }


    public function store(Request $r)
    {
        return $this->Section->store($r);
    }

    public function update(StoreSectionRequest $request)
    {
        return $this->Section->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->Section->destroy($request);
    }

    public function test()
    {
        $product = Product::find(1)->first();

        return $product->image;
    }

    public function getproducts($id)
    {
        return $this->Section->getproducts($id);
    }


}
