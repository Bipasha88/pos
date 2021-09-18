<?php

namespace Tests\Unit;

use App\BusinessObjects\Employee;
use App\Repository\Employee\IEmployeeRepository;
use App\Services\Employee\EmployeeService;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class EmployeeServiceTest extends TestCase
{   
    private $_employeeRepositoryMock;

    public static function setUpBeforeClass(): void
    {

    }

    protected function setUp(): void
    {
        $this->_employeeRepositoryMock = $this->createMock(IEmployeeRepository::class);
    }

    protected function tearDown(): void
    {

    }

    public static function tearDownAfterClass(): void
    {

    }

    public function test_getEmployees_ifAnyEmployeeExists_returnTheEmployee() {
        //arrange
        $_employeeMock = $this->createMock(Employee::class);
        $_employeeMock->name = "Asif";
        $_employeeMock->address = "Chittagong";
        $_employeeMock->phone = "01796406979";
        $_employeeMock->email = "aasif0430@gmail.com";

        $this->_employeeRepositoryMock
            ->expects($this->once())
            ->method('get')
            ->with(array(
                'name' => $_employeeMock->name,
                'address' => $_employeeMock->address,
                'phone' => $_employeeMock->phone,
                'email' => $_employeeMock->email,
                ));

        //act & assert
        $employeeService = new EmployeeService($this->_employeeRepositoryMock);
        $employeeService->getEmployees($_employeeMock);
    }

    public function test_addEmployee(){
        //arrange
        $id = "1";
        $this->_employeeRepositoryMock
            ->expects($this->once())
            ->method('addById')
            ->with($id);

        //act & assert
        $employeeService = new EmployeeService($this->_employeeRepositoryMock);
        $employeeService->addEmployee($id);
    }

    public function test_deleteEmployee(){
        //arrange
        $id = "1";
        $this->_employeeRepositoryMock
            ->expects($this->once())
            ->method('deleteById')
            ->with($id);

        //act & assert
        $employeeService = new EmployeeService($this->_employeeRepositoryMock);
        $employeeService->deleteEmployee($id);
    }

    public function test_archiveEmployee_ifAnyEmployeeExists_archiveTheEmployee() {
        //arrange
        $id = "1";
        $modelMock = $this->createMock(\App\Models\Employee::class);

        $this->_employeeRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($modelMock);

        $modelMock->status = 'archived';
        $modelMock->save();

        //act & assert
        $employeeService = new EmployeeService($this->_employeeRepositoryMock);
        $employeeService->archiveEmployee($id);

    }

}
