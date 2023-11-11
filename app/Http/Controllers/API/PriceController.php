<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Http\Requests\Price\PriceRequest;
use App\Interfaces\PriceInterface;
use DB;

class PriceController extends Controller
{
    protected $priceInterface;

    /**
     * Create a new constructor for this controller
     */
    public function __construct(PriceInterface $priceInterface)
    {
        $this->priceInterface = $priceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->priceInterface->getAllPrices();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PriceRequest  $request
     * @return Response
     */
    public function store(PriceRequest $request)
    {
        return $this->priceInterface->requestPrice($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return $this->priceInterface->getPriceById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PriceRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(PriceRequest $request, int $id)
    {
        return $this->priceInterface->requestPrice($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->priceInterface->deletePrice($id);
    }
}
