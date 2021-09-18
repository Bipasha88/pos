<?php

namespace App\Services;

use App\BusinessObjects\User;

interface IMembershipService
{
    public function CreateUser(User $user);
    public function CreateCustomer($businessName, $email, $password);
    public function GetUser($email);
    public function DeleteUser($email);
    public function GetAllUsers();
    public function GetUserCount();
}
