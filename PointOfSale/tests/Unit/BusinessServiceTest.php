<?php

namespace Tests\Unit;

use App\BusinessObjects\Business;
use App\Repository\Business\IBusinessRepository;
use App\Services\Business\BusinessService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class BusinessServiceTest extends TestCase
{
    private $_businessRepositoryMock;

    public static function setUpBeforeClass(): void
    {

    }

    protected function setUp(): void
    {
        $this->_businessRepositoryMock = $this->createMock(IBusinessRepository::class);
    }

    protected function tearDown(): void
    {

    }

    public static function tearDownAfterClass(): void
    {

    }

    public function test_createBusiness() {
        //arrange
        $businessName = "Business";
        $ownerId = "1";
        $modelMock = $this->createMock(\App\Models\Business::class);

        $this->_businessRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with(array(
                'name' => $businessName,
                'user_id' => $ownerId,
                'slug' => Str::slug($businessName),))
            ->willReturn($modelMock);

        //act & assert
        $businessService = new BusinessService($this->_businessRepositoryMock);
        $businessService->createBusiness($businessName, $ownerId);
    }

    public function test_createBusiness_nameExists_throwsException(){

        $this->expectException(Exception::class);

        $businessName = "Business";
        $ownerId = "1";

        $builderMock = $this->createMock(Builder::class);
        $modelMock = $this->createMock(\App\Models\Business::class);

        $this->_businessRepositoryMock
            ->expects($this->once())
            ->method('where')
            ->with("name", $businessName)
            ->willReturn($builderMock);

        $builderMock
            ->expects($this->once())
            ->method('first')
            ->willReturn($modelMock);

        $businessService = new BusinessService($this->_businessRepositoryMock);
        $businessService->createBusiness($businessName, $ownerId);
    }


    public function test_getBusiness_ifAnyBusinessExists_returnTheBusiness() {
        //arrange
        $id = "1";
        $modelMock = $this->createMock(\App\Models\Business::class);
        $this->_businessRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn($modelMock);

        //act & assert
        $businessService = new BusinessService($this->_businessRepositoryMock);
        $businessService->getBusiness($id);
    }

    public function test_updateBusiness() {
        //arrange
        $_businessMock = $this->createMock(Business::class);
        $_businessMock->name = "Business";
        $_businessMock->address = "Narayanganj";
        $_businessMock->phone = "018765845";
        $_businessMock->email = "dolasaha88@gmail.com";
        $_businessMock->website = "business.com";
        $id = "2";

        $this->_businessRepositoryMock
            ->expects($this->once())
            ->method('updateById')
            ->with($id, array(
                'name' => $_businessMock->name,
                'address' => $_businessMock->address,
                'phone' => $_businessMock->phone,
                'email' => $_businessMock->email,
                'website' => $_businessMock->website,));

        //act & assert
        $businessService = new BusinessService($this->_businessRepositoryMock);
        $businessService->updateBusiness($id, $_businessMock);
    }

    public function test_deleteBusiness(){
        //arrange
        $id = "1";
        $this->_businessRepositoryMock
            ->expects($this->once())
            ->method('deleteById')
            ->with($id);

        //act & assert
        $businessService = new BusinessService($this->_businessRepositoryMock);
        $businessService->deleteBusiness($id);
    }

    public function test_getAllBusinesses_ifAnyBusinessExists_returnsAllBusinesses(){
        //arrange
        $businesses = collect([new \App\Models\Business(), new \App\Models\Business()]);
        $this->_businessRepositoryMock
            ->method('getPaginated')
            ->willReturn($businesses);

        //act & assert
        $businessService = new BusinessService($this->_businessRepositoryMock);
        $this->assertCount(2,$businessService->getAllBusinesses());
    }

    public function test_archiveBusiness_ifAnyBusinessExists_archiveTheBusiness() {
        //arrange
        $id = "1";
        $modelMock = $this->createMock(\App\Models\Business::class);

        $this->_businessRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($modelMock);

        $modelMock->status = 'archived';
        $modelMock->save();

        //act & assert
        $businessService = new BusinessService($this->_businessRepositoryMock);
        $businessService->archiveBusiness($id);
    }
}
