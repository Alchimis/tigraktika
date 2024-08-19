<?php

namespace App\Http\Controllers;

use App\Dto\MoveDTO;
use App\Dto\AddComponentToProductDTO;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Dto\CreateProductsDTO;

class ProductController extends Controller
{
    //
    public function __construct(private ProductService $productService) {}
    public function getAllProducts(Request $request){
        $products = $this->productService->getAllProducts();
        return response()->json($products, 200);
    }
    public function createProduct(Request $request){
        $data = $request->validate([
            "title"    => "required|string",
            "amount"   => "required|min:0",
            "source"   => "required|in:PRODUCTION,STORAGE",
            "welding"  => "required|min:0",
            "assembly" => "required|min:0",
            "electro"  => "required|min:0",
        ]);
        $product = $this->productService->createProduct($data);
        return response()->json(["id" => $product->id]);
    }

    public function move(Request $request){
        $data = $request->validate([
            "product_id" => "required|exists:products,id",
            "where" => "required|in:UP,DOWN",
        ]);
        $moved = $this->productService->move(new MoveDTO($data["product_id"], $data["where"]));
        
        return response()->json(["moved"=> $moved]);
    }

    public function addComponentToProduct(Request $request) { 
        $data = $request->validate([
            "product_id" => "required|exists:products,id",
            "component_id" => "required|exists:components,id",
        ]);

        
        $this->productService->addProduct(new AddComponentToProductDTO($data["product_id"], $data["component_id"]));
        return response("created", 201);
    }

    public function deleteProduct(Request $request) {
        $data = $request->validate([
            "product_id" =>  "required|exists:products,id",
        ]);
        $this->productService->delete($data["product_id"]);
        return response("deleted", 200);
    }

    public function createProducts(Request $request){
        $data = $request->validate([
            "products" => "required|array|min:1",
            "products.*.title"    => "required|string",
            "products.*.amount"   => "required|min:0",
            "products.*.source"   => "required|in:PRODUCTION,STORAGE",
            "products.*.welding"  => "required|min:0",
            "products.*.assembly" => "required|min:0",
            "products.*.electro"  => "required|min:0",
        ]);
        $products = [];
        foreach ($data["products"] as $productsData) {
            $products[] = new CreateProductsDTO(
                $productsData["title"],
                $productsData["amount"],
                $productsData["source"],
                $productsData["welding"],
                $productsData["assembly"],
                $productsData["electro"],
            );
        }
        $this->productService->createProducts($products);
        return response("created", 201);
    }
}
