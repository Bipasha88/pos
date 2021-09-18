<?php

namespace App\Http\Controllers\User;

use Mockery\Exception;
use App\Utility\ILogger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\ApiModels\EmployeeListModel;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Requests\CommonListRequest;

class EmployeeController extends Controller
{
    private $logger;

    public function __construct(ILogger $iLogger)
    {
        $this->logger = $iLogger;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(CommonListRequest $request)
    {
        $model = resolve('App\ApiModels\Employee\EmployeeListModel');
        $userId = request()->user()->id;
        $employees = $model->getEmployees($userId, $request);

        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeCreateRequest $request
     * @return JsonResponse
     */
    public function store(EmployeeCreateRequest $request)
    {
        $userId = request()->user()->id;
        $model = resolve('App\ApiModels\Employee\EmployeeCreationModel');

        try {
            $employee = $model->createEmployee($request,$userId);
            return response()->json($employee);
        } catch (Exception $e) {
            $this->logger->write($e->getMessage(),"error", $e);
            $data = (object)array('errors' => 'Failed to create emlpoyee');
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $model = resolve('App\ApiModels\Employee\EmployeeUpdateModel');
        $employee = $model->getEmployee($id);

        return response()->json(['employee'=>$employee],201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        try
        {
            $model = resolve('App\ApiModels\Employee\EmployeeUpdateModel');
            $model->updateEmployee($request, $id);

            return response()->json([
                'success' => 'Employee updated successfully'
            ],200);
        }
        catch (Exception $exception)
        {
            $this->_logger->write("Failed to update employee","error", $exception);
            throw new Exception( "Cannot update Employee", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $model = resolve('App\ApiModels\Employee\EmployeeListModel');
        $model->deleteEmployee($id);
        $data = (object)array('status' => 'success');
        return response()->json($data);
    }

    public function getBusinessList()
    {
        $model = resolve('App\ViewModels\Business\Employee\EmployeeCreationModel');
        $data = $model->getBusinessList();
        return response()->json($data);
    }
}
