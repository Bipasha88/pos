<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Http\Requests\GetVendorListRequest;
use App\Http\Requests\UpdateVendorModel;
use App\Http\Requests\UpdateVendorRequest;
use App\Utility\ILogger;
use Illuminate\Http\Request;
use Exception;

class VendorController extends Controller
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
    public function index(GetVendorListRequest $request)
    {
        $model = resolve('App\ApiModels\Vendor\VendorListModel');
        $user = request()->user();
        $vendors = $model->getVendors($user, $request);

        return response()->json($vendors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateVendorRequest $request)
    {
        $model = resolve('App\ApiModels\Vendor\CreateVendorModel');
        $vendor = $model->createVendor($request);
        return response()->json([
            'vendor' => $vendor,
            'success' => 'Your vendor has been created successfully'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = resolve('App\ApiModels\Vendor\GetVendorModel');
        try {
            $vendor = $model->getVendor($id);
            return response()->json($vendor,201);
        }catch (Exception $exception) {
            $this->logger->write("Failed to show vendor", "error", $exception);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateVendorRequest $request, $id)
    {
        $model = resolve('App\ApiModels\Vendor\UpdateVendorModel');
        try {
            $model->updateVendor($id, $request);
            return response()->json([
                'success' => 'Your vendor has been updated successfully'
            ],201);
        }catch (Exception $exception) {
            $this->logger->write("Failed to update vendor", "error", $exception);
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
        $model = resolve('App\ApiModels\Vendor\VendorListModel');
        try {
            $model->deleteVendor($id);
            $data = (object)array('status' => 'success');
            return response()->json($data);
        }catch (Exception $exception) {
            $this->logger->write("Failed to delete branch", "error", $exception);
        }
    }

    public function getOwnedBranches(){
        $user = request()->user();
        $model = resolve('App\ApiModels\Vendor\OwnedBranchListModel');
        $data = $model->ownedBranchesList($user);
        return response()->json($data);
    }
}
