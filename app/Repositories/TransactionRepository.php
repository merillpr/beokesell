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
}