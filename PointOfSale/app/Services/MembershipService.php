<?php

namespace App\Services;

use App\BusinessObjects\User;
use App\Repository\User\IUserRepository;
use App\Services\Business\IBusinessService;
use App\Services\Email\IEmailService;
use Exception;
use Illuminate\Support\Facades\DB;

class MembershipService implements IMembershipService
{
    protected $userRepository;
    private $businessService;
    private $emailService;

    public function __construct(IUserRepository $userRepository, IBusinessService $businessService, IEmailService $emailService)
    {
        $this->userRepository = $userRepository;
        $this->businessService = $businessService;
        $this->emailService = $emailService;
    }

    public function CreateUser(User $user)
    {
        $existingEmail = $this->userRepository
            ->where('email', $user->email)
            ->first();

        if ($existingEmail != null){
            throw new Exception("This name or email is already used");
        }
        else {
            return $this->userRepository->create([
                "email" => $user->email,
                "password" => $user->password,
            ]);
        }
    }

    public function CreateCustomer($businessName, $email, $password){
        $user = new User();
        $user->email = $email;
        $user->password = $password;

        $transection = function () use ($user, $businessName){
            try {
                $customer = $this->CreateUser($user);
                $this->businessService->createBusiness($businessName, $customer->id);
                $subject = "Customer registration";
                $body = array(
                    "body" => "Your account has been created successfully"
                );
                $template = "admin.email.email";
                $this->emailService->SendSingleEmail($user->email, $businessName, $subject, $body, $template);
                return $customer;
            }catch (Exception $exception){
                DB::rollBack();
                throw new Exception("Cannot create customer");
            }
        };

        $customer = DB::transaction($transection);
        return $customer;
    }

    public function GetUser($email)
    {
        $user = $this->userRepository->where('email', $email)->get();
        return $user;
    }

    public function DeleteUser($email)
    {
        return $this->userRepository->where('email', $email)->delete();
    }

    public function GetAllUsers()
    {
        $users = $this->userRepository->all();
        return $users;
    }

    public function GetUserCount()
    {
        $userCount =  $this->userRepository->count();
        return $userCount;
    }
}
