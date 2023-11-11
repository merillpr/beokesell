<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\Product\ProductRequest;
use App\Interfaces\ProductInterface;
use DB;

class ProductController extends Controller
{
    protected $productInterface;

    /**
     * Create a new constructor for this controller
     */
    public function __construct(ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->productInterface->getAllProducts();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
       return $this->productInterface->requestProduct($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return $this->productInterface->getProductById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ProductRequest $request, int $id)
    {
        return $this->productInterface->requestProduct($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->productInterface->deleteProduct($id);
    }
}
