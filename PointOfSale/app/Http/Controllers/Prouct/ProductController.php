<?php

namespace App\Http\Controllers\Prouct;

use Exception;
use App\Utility\ILogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommonListRequest;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    private $loger;

    public function __construct(ILogger $loger)
    {
        $this->loger = $loger;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommonListRequest $request)
    {
        $model = resolve('App\ApiModels\Product\ProductListModel');
        $userId = request()->user()->id;
        $products = $model->getProducts($userId, $request);

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        try
        {
            $model = resolve('App\ApiModels\Product\CreateProductModel');
            $model->createProduct($request);

            return response()->json([
                'success' => 'Product created successfully'
            ],200);
        }
        catch (Exception $e)
        {
            $this->loger->write("Failed to create product", "error", $e);

            return response()->json(['error' => 'Failed to create product'], 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $model = resolve('App\ApiModels\Product\GetProductModel');
            $product = $model->getProduct($id);

            return response()->json($product);
        }
        catch (Exception $e)
        {
            $this->loger->write("Failed to get product", "error", $e);

            return response()->json(['error' => 'Failed to get product'], 409);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try
        {
            $model = resolve('App\ApiModels\Product\ProductUpdateModel');
            $model->updateProduct($request, $id);

            return response()->json([
                'success' => 'Product updated successfully'
            ],200);
        }
        catch (Exception $exception)
        {
            $this->_logger->write("Failed to update Product","error", $exception);
            throw new Exception( "Cannot update Product", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $model = resolve('App\ApiModels\Product\DeleteProductModel');
            $model->deleteProduct($id);
            $data = (object)array('status' => 'success');

            return response()->json($data);
        }
        catch (Exception $e)
        {
            $this->loger->write("Failed to delete product", "error", $e);

            return response()->json(['error' => 'Failed to delete product'], 409);
        }
    }

    public function getAllCategories()
    {
        $model = resolve('App\ApiModels\Product\ProductUpdateModel');
        $categories = $model->getAllCategories();

        return response()->json($categories);
    }

    public function getOwenedBusiness()
    {
        $model = resolve('App\ApiModels\Product\CreateProductModel');
        $businesses = $model->getOwenedBusiness(Auth::id());

        return response()->json($businesses);
    }
}
