<?php

namespace App\Repositories;

use App\Http\Requests\Price\PriceRequest;
use App\Interfaces\PriceInterface;
use App\Traits\ResponseAPI;
use App\Models\Price;
use DB;
use Illuminate\Database\QueryException;

class PriceRepository implements PriceInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllPrices()
    {
        try {
            $price = Price::select('*','products.name as product_name', 'prices.id as id')
            ->join('products','products.id','=','prices.product_id')->get();
            return $this->success(
                message: "All Prices", 
                data: $price
            );
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getPriceById($id)
    {
        try {
            $price = Price::find($id);
            
            if(!$price) return $this->error(
                message: "No Price with ID $id", 
                statusCode: 404
            );

            return $this->success("Price Detail", $price);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestPrice(PriceRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $price = $id ? Price::find($id) : new Price;

            if($id && !$price) return $this->error("No Price with ID $id", 404);

            $price->product_id = $request->product_id;
            $price->purchase_price = $request->purchase_price;
            $price->selling_price = $request->selling_price;
            $price->save();

            DB::commit();
            $message = $id ? "Price updated" : "Price created";
            $statusCode = $id ? 200 : 201;
            return $this->success(
                message: $message, 
                data: $price, 
                statusCode: $statusCode);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deletePrice($id)
    {
        DB::beginTransaction();
        try {
            $price = Price::find($id);

            if(!$price) return $this->error(message: "No price with ID $id", statusCode: 404);

            try {
                $price->delete();
            } catch (QueryException $e) {
                DB::rollBack();
                return $this->error("Cannot delete price. The price is used", statusCode: 400);
            }

            DB::commit();
            return $this->success("Price deleted", $price);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}