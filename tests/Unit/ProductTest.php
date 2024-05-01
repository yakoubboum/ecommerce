<?php

namespace Tests\Unit;

use App\Services\ProductsService;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected $productService;
    protected $product;

    public function setUp():void {
        parent::setUp();
        $this->productService = $this->app->make(ProductsService::class);
        $this->product=[
            "name"=>"Test Product",
            "description"=>"Test",
            "section_id"=>'1',
            "price"=>30,
            "discount"=>"10",
            "delivery_price"=>"10",
            "delivery_time"=>"10",
            "quantity"=>"10",
        ];
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_create_database()
    {
        $created_product=$this->productService->createProduct($this->product);
        $this->assertDatabaseHas('product_translations',[
            "name"=>"Test Product",
        ]);
        // $this->assertDatabaseHas('product_details',[
        //     "size"=>30,
        // ]);
    }
}
