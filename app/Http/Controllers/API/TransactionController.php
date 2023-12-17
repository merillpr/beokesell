<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Interfaces\TransactionInterface;
use DB;

class TransactionController extends Controller
{
    protected $transactionInterface;

    /**
     * Create a new constructor for this controller
     */
    public function __construct(TransactionInterface $transactionInterface)
    {
        $this->transactionInterface = $transactionInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->transactionInterface->getAllTransactions();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TransactionRequest  $request
     * @return Response
     */
    public function store(TransactionRequest $request)
    {
        return $this->transactionInterface->requestTransaction($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return $this->transactionInterface->getTransactionById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TransactionRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TransactionRequest $request, int $id)
    {
        return $this->transactionInterface->requestTransaction($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->transactionInterface->deleteTransaction($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function recaps()
    {
        return $this->transactionInterface->getAllTransactionRecaps();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function recap(int $id)
    {
        return $this->transactionInterface->getTransactionRecapById($id);
    }

    /**
     * Display a listing data from specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function recapList(int $id)
    {
        return $this->transactionInterface->getTransactionRecapListById($id);
    }
}
