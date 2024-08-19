<?php
  namespace App\Services;

  use App\Dto\AddComponentToProductDTO;
  use App\Dto\Direction;
  use App\Dto\MoveDTO;
  use App\Models\Product;
  use App\Exceptions\BasicException;


  class ProductService {

    public function getAllProducts(): array {
      $products = Product::orderBy("position")->get();
      $productsWithComponents = $products->reduce(function($result, Product $product) {  
        $result[] = ["product" => $product, "components" => $product->hasComponents()];
        return $result;
      }, []);

      return$productsWithComponents;
    }

    public function createProduct(array $data): Product{
      $maxPosition = Product::max("position");
      $data["position"] = $maxPosition+1;
      $product = Product::create($data);
      $product->save();
      return $product;
    }

    private function swapPositionsAndSave(Product $first, Product $second)
    {
      $newPos = $first->position;
      $oldPos = $second->position;
      $first->position = $oldPos;
      $second->position = $newPos;
      $first->save();
      $second->save();
    }

    public function move(MoveDTO $data): bool {
      try {
        $product = Product::find($data->product_id)->first();
      } catch (\Exception $e){
        return false;
      }

      if ($product === null) {
        return false;
      }

      switch ($data->where){
        case Direction::UP:
          try {
            $nextProduct = Product::where("position", ">", $product->position)->orderBy("position")->first();
          } catch (\Exception $e){
            throw new BasicException("Error with getting next position", 500, $e);
          }
          break;
        case Direction::DOWN:
          try {
            $nextProduct = Product::where("position", "<", $product->position)->orderBy("position","desc")->first();
          } catch (\Exception $e){
            throw new BasicException("Error with getting next position", 500, $e);
          }
          break;
      }
      if ($nextProduct === null) {
        throw new BasicException("Can't move product", 404);
      }
      ProductService::swapPositionsAndSave($nextProduct, $product);
      return true;
    }

    public function delete(int $productId){
      $product = Product::find($productId);
      if ($product === null) {
        throw new BasicException("Product with id :".$productId.": not found", 404);
      }
      $product->delete();
    }

    public function addProduct(AddComponentToProductDTO $data){
      $product = Product::find($data->productId);
      if ($product === null) {
        throw new BasicException("Product with id :".$data->productId.": not found", 404);
      }
      try{
        $product->hasComponents()->attach($data->componentId);
      } catch (\Exception $e) {
        throw new BasicException("Error with attaching component (id):".$data->componentId.": to product (id):".$data->productId.":", 500, $e);
      }
    }

    /** 
    *  @var \App\Dto\CreateProductsDTO[]
    **/
    public function createProducts(array $products){
      $maxPosition = Product::max("position");
      try{
        foreach ($products as $product){
          $maxPosition++;
          $createdProduct = Product::create([
            "title"    =>  $product->title,
            "amount"   => $product->amount,
            "source"   => $product->source,
            "welding"  => $product->welding,
            "assembly" => $product->assembly,
            "electro"  => $product->electro,
            "position" => $maxPosition,
          ]);
          $createdProduct->save();
        }
      } catch (\Exception $e) {
        throw new BasicException("Error with creating products:", 500, $e);
      }
    }
  }

  