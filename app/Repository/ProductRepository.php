<?php


namespace App\Repository;

use App\Models\Product;
use App\Repository\ProductRepositoryInterface;



class ProductRepository implements ProductRepositoryInterface
{

    public function index()
    {
        
        $data = Product::all();
        
        return \view('Dashboard.Products.index', \compact('data'));
    }

    public function show($id)
    {
    }

    public function store($r)
    {

        Section::create([
            'name' => $r->name,
        ]);
        session()->flash('add');
        return back();
    }

    public function update($request)
    {
        $section = Section::findOrFail($request->id);
        $section->update([
            'name' => $request->input('name'),
        ]);
        session()->flash('edit');
        return redirect()->route('sections.index');
    }

    public function destroy($request)
    {
        Section::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('sections.index');
    }
}