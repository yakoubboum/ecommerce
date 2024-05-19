<?php


namespace App\Http\Controllers\Api;


use App\Models\Product;
use App\Traits\UploadTrait;

use Illuminate\Http\Request;
use App\Models\ProductTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\BaseController;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

// use Illuminate\Support\Str;

class ProductController extends BaseController
{
    use UploadTrait;

    public function index()
    {
        $data = Product::orderBy('created_at', 'desc')->get();

        return \response()->json($data);
    }
    public function store(Request $request)
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

            return \response()->json($product);
        } catch (\Exception $e) {
            DB::rollback();
            return \response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        if (ProductTranslation::where('name', $request->name)->where('product_id', '!=', $id)->first() // Exclude current product ID
        ) {

        return \response()->json('The name has already been taken');

        }
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
            if ($request->hasFile('photo') && $product->image) {
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
            return \response()->json($product);
        } catch (\Exception $e) {
            DB::rollback();
            return \response()->json('error');
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

            return \response()->json($product);
        } catch (\Exception $e) {
            DB::rollback(); // Rollback if any errors occur
            return \response()->json($product);;
        }
    }



    public function webscrap(){
        // MuiBox-root mui-style-1q101cz

        $client= new Client(['verify'=>false , 'cookies'=>true]);

        $headers=[];

        $options=[
            'multipart'=>[

            ],
        ];

        $url='https://www.dubizzle.com.eg/vehicles/cars-for-sale/?filter=price_between_8000_to_20000000';

        $request=new \GuzzleHttp\Psr7\Request('GET',$url,$headers);

        $res=$client->sendAsync($request,$options)->wait();

        if($res->getStatusCode()==200){
            $dom=new Dom();

            $dom->loadStr($res->getBody()->getContents());

            \dd($dom->find('_95eae7db')[0]);
        }

    }
}
