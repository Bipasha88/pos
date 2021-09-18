<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonListRequest;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Utility\ILogger;
use Exception;

class CategoryController extends Controller
{   
    private  $logger;

    public function __construct(ILogger $iLogger) 
    {
        $this->logger = $iLogger; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CommonListRequest $request)
    {
        $model = resolve('App\ApiModels\Category\CategoryListModel');
        $userId = request()->user()->id;
        $categories = $model->getCategories($userId, $request);

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        $userId = request()->user()->id;
        $model = resolve('App\ApiModels\Category\CreateCategoryModel');
        try {
            $model->createCategory($request,$userId);
            return response()->json([
                'success' => 'Your category has been created successfully'
            ],200);
        }catch (Exception $exception) {
            $this->logger->write("Failed to create category", "error", $exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = resolve('App\ApiModels\Category\GetCategoryModel');
        try {
            $category = $model->getCategory($id);
            return response()->json(['category'=>$category],201);
        }catch (Exception $exception) {
            $this->logger->write("Failed to show category", "error", $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $model = resolve('App\ApiModels\Category\UpdateCategoryModel');
        try {
            $model->updateCategory($id, $request);
            return response()->json([
                'success' => 'Your category has been updated successfully'
            ],201);
        }catch (Exception $exception) {
            $this->logger->write("Failed to update category", "error", $exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = resolve('App\ApiModels\Category\CategoryListModel');
        try {
            $model->deleteCategory($id);
            $data = (object)array('status' => 'success');
            return response()->json($data);
        }catch (Exception $exception) {
            $this->logger->write("Failed to delete category", "error", $exception);
        }
    }
}
