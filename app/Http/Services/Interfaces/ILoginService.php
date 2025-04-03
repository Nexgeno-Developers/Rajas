<?php

namespace App\Http\Services\Interfaces;


interface ILoginService
{
    public function __construct(IUserService $userService);

    public function login($credentials);

    public function forgotPassword($request);

    public function resetPassword($request);
    
    public function logout();
}