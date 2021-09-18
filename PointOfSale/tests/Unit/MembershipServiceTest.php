<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repository\User\IUserRepository;
use App\Services\Business\IBusinessService;
use App\Services\MembershipService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class MembershipServiceTest extends TestCase
{
    private $_membershipRepositoryMock;
    private $_businessServiceMock;

    public static function setUpBeforeClass(): void {}

    protected function setUp(): void
    {
        $this->_membershipRepositoryMock = $this->createMock(IUserRepository::class);
        $this->_businessServiceMock = $this->createMock(IBusinessService::class);
    }

    protected function tearDown(): void {}

    public static function tearDownAfterClass(): void {}

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_creteMember_returnMember(){
        //arrange
        $_userMock = $this->createMock(\App\BusinessObjects\User::class);
        $_userMock->name = "Business";
        $_userMock->email = "devskill@gmail.com";
        $_userMock->password = "123456";
        $modelMock = $this->createMock(User::class);

        $this->_membershipRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with(array(
                "email" => $_userMock->email,
                "password" => $_userMock->password,))
            ->willReturn($modelMock);

        //act and assert
        $membershipService = new MembershipService($this->_membershipRepositoryMock, $this->_businessServiceMock);
        $membershipService->CreateUser($_userMock);
    }

    public function test_CreateUser_nameExists_throwsException(){

        $this->expectException(Exception::class);

        $_userMock = $this->createMock(\App\BusinessObjects\User::class);
        $_userMock->email = "devskill@gmail.com";
        $_userMock->password = "123456";

        $builderMock = $this->createMock(Builder::class);
        $modelMock = $this->createMock(User::class);

        $this->_membershipRepositoryMock
            ->expects($this->once())
            ->method('where')
            ->with("email", $_userMock->email)
            ->willReturn($builderMock);

        $builderMock
            ->expects($this->once())
            ->method('first')
            ->willReturn($modelMock);

        $membershipService = new MembershipService($this->_membershipRepositoryMock, $this->_businessServiceMock);
        $membershipService->CreateUser($_userMock);
    }

    public function test_getMember_ifAnyMemberExists_returnMember(){
        //arrange
        $email = 'test@email.com';
        $builderMock= $this->createMock(Builder::class);
        $modelMock = $this->createMock(User::class);
        $this->_membershipRepositoryMock
            ->expects($this->once())
            ->method('where')
            ->with('email', $email)
            ->willReturn($builderMock);

        $builderMock
            ->expects($this->once())
            ->method('get')
            ->willReturn($modelMock);

        //act an assert
        $membershipService = new MembershipService($this->_membershipRepositoryMock, $this->_businessServiceMock);
        $membershipService->GetUser($email);
    }

    public function test_deleteMember_ifmemberExists(){
        //arrange
        $email = 'test@email.com';
        $builderMock= $this->createMock(Builder::class);

        $this->_membershipRepositoryMock
            ->expects($this->once())
            ->method('where')
            ->with('email', $email)
            ->willReturn($builderMock);

        $builderMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn($builderMock);
        $membershipService = new MembershipService($this->_membershipRepositoryMock, $this->_businessServiceMock);

        //act an assert
        $membershipService->DeleteUser($email);
    }

    public function test_getAllMembers_ifmemberExists_returnMembers(){
        //arrange
        $collection = ([new User(),new User()]);

        $this->_membershipRepositoryMock->method('all')->willReturn($collection);
        $membershipService = new MembershipService($this->_membershipRepositoryMock, $this->_businessServiceMock);

        //act
        $result = $membershipService->GetAllUsers();

        //assert
        $this->assertCount(2,$result);
    }

    public function test_getMemberCount_memberExists_returnsMemberCount(){
        //arrange
        $collection = ([new User()]);
        $this->_membershipRepositoryMock->method('count')->willReturn($collection);
        $membershipService = new MembershipService($this->_membershipRepositoryMock, $this->_businessServiceMock);

        //act
        $result = $membershipService->GetUserCount();

        //assert
        $this->assertCount(1,$result);
    }
}

