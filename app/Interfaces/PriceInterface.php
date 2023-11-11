<?php

namespace App\Interfaces;

use App\Http\Requests\Price\PriceRequest;

interface PriceInterface
{
    /**
     * Get all Prices
     * 
     * @method  GET api/price
     * @access  public
     */
    public function getAllPrices();

    /**
     * Get Price By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/price/{id}
     * @access  public
     */
    public function getPriceById($id);

    /**
     * Create | Update Price
     * 
     * @param   PriceRequest      $request
     * @param   integer           $id
     * 
     * @method  POST    api/price       For Create
     * @method  PUT     api/price/{id}  For Update     
     * @access  public
     */
    public function requestPrice(PriceRequest $request, $id = null);

    /**
     * Delete user
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/price/{id}
     * @access  public
     */
    public function deletePrice($id);
}