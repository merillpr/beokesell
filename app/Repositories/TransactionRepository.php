<?php

namespace App\Repositories;

use App\Http\Requests\Transaction\TransactionRequest;
use App\Interfaces\TransactionInterface;
use App\Traits\ResponseAPI;
use App\Models\Transaction;
use DB;

class TransactionRepository implements TransactionInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllTransactions()
    {   
        try {
            $transaction = Transaction::all();
            return $this->success(
                message: "All Transactions", 
                data: $transaction
            );
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getTransactionById($id)
    {
        try {
            $transaction = Transaction::find($id);
            
            if(!$transaction) return $this->error(
                message: "No Transaction with ID $id", 
                statusCode: 404
            );

            return $this->success("Transaction Detail", $transaction);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestTransaction(TransactionRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $transaction = $id ? Transaction::find($id) : new Transaction;

            if($id && !$transaction) return $this->error("No Transaction with ID $id", 404);

            $transaction->product_id = $request->product_id;
            $transaction->price_id = $request->price_id;
            $transaction->qty = $request->qty;
            $transaction->is_purchase = $request->is_purchase;
            $transaction->save();

            DB::commit();
            $message = $id ? "Transaction updated" : "Transaction created";
            $statusCode = $id ? 200 : 201;
            return $this->success(
                message: $message, 
                data: $transaction, 
                statusCode: $statusCode);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteTransaction($id)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::find($id);

            if(!$transaction) return $this->error(message: "No Transaction with ID $id", statusCode: 404);

            $transaction->delete();

            DB::commit();
            return $this->success("Transaction deleted", $transaction);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getAllTransactionRecaps()
    {   
        try {
            $transaction = Transaction::join('products', 'transactions.product_id', '=', 'products.id')
                ->join('prices', 'transactions.price_id', '=', 'prices.id')
                ->select('products.id', 'products.name', 'prices.purchase_price', 'prices.selling_price')
                ->selectRaw('SUM (CASE WHEN transactions.is_purchase is true THEN transactions.qty ELSE 0 END) - SUM (CASE WHEN transactions.is_purchase is false THEN transactions.qty ELSE 0 END) as stock')
                ->groupBy('products.id', 'products.name', 'prices.purchase_price', 'prices.selling_price', 'prices.id')
                ->orderBy('products.name', 'asc')
                ->get();

            return $this->success(
                message: "All Transaction Recaps", 
                data: $transaction
            );
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getTransactionRecapById($id)
    {
        try {
            $transaction = Transaction::join('products', 'transactions.product_id', '=', 'products.id')
                ->join('prices', 'transactions.price_id', '=', 'prices.id')
                ->select('products.id AS product_id', 'prices.id as price_id', 'products.name', 'prices.purchase_price', 'prices.selling_price')
                ->selectRaw('SUM (CASE WHEN transactions.is_purchase is true THEN transactions.qty ELSE 0 END) - SUM (CASE WHEN transactions.is_purchase is false THEN transactions.qty ELSE 0 END) as stock')
                ->where('products.id',$id)
                ->groupBy('products.id', 'products.name', 'prices.purchase_price', 'prices.selling_price', 'prices.id')
                ->orderBy('products.name', 'asc')
                ->get();
            
            if(!$transaction) return $this->error(
                message: "No Transaction Recap with product ID $id", 
                statusCode: 404
            );

            return $this->success("Transaction Recap", $transaction);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getTransactionRecapListById($id)
    {
        try {
            $transaction = Transaction::select('*')
                ->where('transactions.product_id', $id)
                ->selectRaw('CASE WHEN transactions.is_purchase IS TRUE THEN \'In\' ELSE \'Out\' END AS status')
                ->orderBy('transactions.created_at', 'asc')
                ->get();
            
            if(!$transaction) return $this->error(
                message: "No Transaction Recap List with product ID $id", 
                statusCode: 404
            );

            return $this->success("Transaction Recap List", $transaction);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}