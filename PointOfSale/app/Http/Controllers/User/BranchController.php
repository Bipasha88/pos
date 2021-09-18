<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonListRequest;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Utility\ILogger;
use Exception;

class BranchController extends Controller
{
    private $logger;

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

        $model = resolve('App\ApiModels\Branch\BranchListModel');
        $userId = request()->user()->id;
        $branches = $model->getBranches($userId,$request);

        return response()->json($branches);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateBranchRequest $request)
    {
        $userId = request()->user()->id;
        $model = resolve('App\ApiModels\Branch\CreateBranchModel');
        try {
            $model->createBranch($request,$userId);
            return response()->json([
                'success' => 'Your branch has been created successfully'
            ],200);
        }catch (Exception $exception) {
            $this->logger->write("Failed to create branch", "error", $exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = resolve('App\ApiModels\Branch\GetBranchModel');
        try {
            $branch = $model->getBranch($id);
            return response()->json(['branch'=>$branch],201);
        }catch (Exception $exception) {
            $this->logger->write("Failed to show branch", "error", $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        $model = resolve('App\ApiModels\Branch\UpdateBranchModel');
        try {
            $model->updateBranch($id, $request);
            return response()->json([
                'success' => 'Your branch has been updated successfully'
            ],201);
        }catch (Exception $exception) {
            $this->logger->write("Failed to update branch", "error", $exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = resolve('App\ApiModels\Branch\BranchListModel');
        try {
            $model->deleteBranch($id);
            $data = (object)array('status' => 'success');
            return response()->json($data);
        }catch (Exception $exception) {
            $this->logger->write("Failed to delete branch", "error", $exception);
        }
    }
}
