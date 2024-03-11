<?php


namespace App\Repository;

use App\Models\Product;
use App\Models\Section;
use App\Repository\ProductRepositoryInterface;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;




class ProductRepository implements ProductRepositoryInterface
{
    use UploadTrait;

    public function index()
    {

        $data = Product::orderBy('created_at', 'desc')->get();



        $sections = Section::all();
        return \view('Dashboard.Products.index', \compact('data', 'sections'));
    }

    public function edit($id)
    {
        $item = Product::findOrfail($id);

        $sections=Section::all();

        return view('Dashboard.Products.edit',\compact('item','sections'));
    }
    public function show($id)
    {
        
    }

    public function store($request)
    {

        // Validate form data (adjust as needed)
        $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|integer|exists:sections,id',
            'price' => 'required|numeric|min:0.01',
            'discount' => 'nullable|integer|min:0|max:100',
            'delivery_price' => 'nullable|numeric|min:0',
            'delivery_time' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        // Create a new product
        try {
            $product = new Product;
            $product->name = $request->name;
            $product->section_id = $request->section_id;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->delivery_price = $request->delivery_price;
            $product->delivery_time = $request->delivery_time;
            $product->quantity = $request->quantity;
            $product->specifications = $request->specifications;
            // $product->photo = $photoPath; // Set photo path if uploaded
            $product->status = $request->status;; // Assuming product is active by default
            $product->details = $request->details;
            // Save the product to database
            $product->save();

            $this->verifyAndStoreImage($request, 'photo', 'products', 'upload_image', $product->id, 'App\Models\Product');


            DB::commit();
            session()->flash('add');
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|integer|exists:sections,id',
            'price' => 'required|numeric|min:0.01',
            'discount' => 'nullable|integer|min:0|max:100',
            'delivery_price' => 'nullable|numeric|min:0',
            'delivery_time' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        
        
        // Create a new product
        try {
            $product = Product::findOrfail($id);
            if( $request->hasFile( 'photo' ) && $product->image ) {
                Storage::disk('upload_image')->delete("products/" . $product->image->filename);
                $product->image->delete();
            }
            $product->name = $request->name;
            $product->section_id = $request->section_id;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->delivery_price = $request->delivery_price;
            $product->delivery_time = $request->delivery_time;
            $product->quantity = $request->quantity;
            $product->specifications = $request->specifications;

            $product->status = $request->status;; // Assuming product is active by default
            $product->details = $request->details;

            $product->save();

            $this->verifyAndStoreImage($request, 'photo', 'products', 'upload_image', $product->id, 'App\Models\Product');


            DB::commit();
            session()->flash('add');
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Find the product model with the given ID
            $product = Product::findOrFail($id);

            // Delete the product image (if it exists)
            if ($product->image) {
                // Delete the image from storage
                Storage::disk('upload_image')->delete("products/" . $product->image->filename);

                // Delete the associated image model (optional)

                $product->image->delete();
            }

            // Delete the product record
            $product->delete();

            DB::commit(); // Commit the transaction if everything went smoothly
        } catch (\Exception $e) {
            DB::rollback(); // Rollback if any errors occur
            return back()->with('error', 'Failed to delete product. Please try again.');
        }
        session()->flash('delete');
        return redirect()->route('products.index');
    }
}
