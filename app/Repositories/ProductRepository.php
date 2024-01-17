<?php

namespace App\Repositories;

use App\Http\Requests\Product\ProductRequest;
use App\Interfaces\ProductInterface;
use App\Traits\ResponseAPI;
use App\Models\Product;
use DB;
use Illuminate\Database\QueryException;

class ProductRepository implements ProductInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllProducts()
    {
        try {
            $product = Product::all();
            return $this->success(
                message: "All Products", 
                data: $product
            );
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getProductById($id)
    {
        try {
            $product = Product::find($id);
            
            if(!$product) return $this->error(
                message: "No product with ID $id", 
                statusCode: 404
            );

            return $this->success("Product Detail", $product);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestProduct(ProductRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $product = $id ? Product::find($id) : new Product;

            if($id && !$product) return $this->error("No product with ID $id", 404);

            $product->name = $request->name;
            $product->save();

            DB::commit();
            $message = $id ? "product updated" : "product created";
            $statusCode = $id ? 200 : 201;
            return $this->success(
                message: $message, 
                data: $product, 
                statusCode: $statusCode);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);

            if(!$product) return $this->error(message: "No product with ID $id", statusCode: 404);

            try {
                $product->delete();
            } catch (QueryException $e) {
                DB::rollBack();
                return $this->error("Cannot delete product. The product is used", statusCode: 400);
            }

            DB::commit();
            return $this->success("Product deleted", $product);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}