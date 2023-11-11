<?php

namespace App\Interfaces;

use App\Http\Requests\Product\ProductRequest;

interface ProductInterface
{
    /**
     * Get all products
     * 
     * @method  GET api/product
     * @access  public
     */
    public function getAllProducts();

    /**
     * Get Product By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/product/{id}
     * @access  public
     */
    public function getProductById($id);

    /**
     * Create | Update product
     * 
     * @param   ProductRequest    $request
     * @param   integer           $id
     * 
     * @method  POST    api/product       For Create
     * @method  PUT     api/product/{id}  For Update     
     * @access  public
     */
    public function requestProduct(ProductRequest $request, $id = null);

    /**
     * Delete user
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/product/{id}
     * @access  public
     */
    public function deleteProduct($id);
}