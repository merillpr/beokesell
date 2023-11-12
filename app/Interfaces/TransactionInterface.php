<?php

namespace App\Interfaces;

use App\Http\Requests\Transaction\TransactionRequest;

interface TransactionInterface
{
    /**
     * Get all Transactions
     * 
     * @method  GET api/transaction
     * @access  public
     */
    public function getAllTransactions();

    /**
     * Get Transaction By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/transaction/{id}
     * @access  public
     */
    public function getTransactionById($id);

    /**
     * Create | Update Transaction
     * 
     * @param   TransactionRequest      $request
     * @param   integer           $id
     * 
     * @method  POST    api/transaction       For Create
     * @method  PUT     api/transaction/{id}  For Update     
     * @access  public
     */
    public function requestTransaction(TransactionRequest $request, $id = null);

    /**
     * Delete user
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/transaction/{id}
     * @access  public
     */
    public function deleteTransaction($id);
}