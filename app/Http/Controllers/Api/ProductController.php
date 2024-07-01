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

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
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
            $product->status = $request->status ?? true; // Assuming product is active by default
            $product->details = $request->details;
            $product->save();

            $this->verifyAndStoreImage($request, 'photo', 'products', 'upload_image', $product->id, 'App\Models\Product');

            DB::commit();

            return response()->json($product);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json($e, 500); // Set appropriate status code for error
        }
    }

    public function update(Request $request, int $id)
    {
        if (ProductTranslation::where('name', $request->name)
            ->where('product_id', '!=', $id)
            ->first()) {
            return response()->json('The name has already been taken');
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

        try {
            $product = Product::findOrFail($id);

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
            $product->status = $request->status ?? true; // Assuming product is active by default
            $product->details = $request->details;

            $product->save();

            $this->verifyAndStoreImage($request, 'photo', 'products', 'upload_image', $product->id, 'App\Models\Product');

            DB::commit();
            session()->flash('add');
            return response()->json($product);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json('error', 500); // Set appropriate status code
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            if ($product->image) {
                Storage::disk('upload_image')->delete("products/" . $product->image->filename);
                $product->image->delete(); // Optional, delete associated image model
            }

            $product->delete();

            DB::commit();
            return response()->json($product);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json('error', 500); // Set appropriate status code
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
