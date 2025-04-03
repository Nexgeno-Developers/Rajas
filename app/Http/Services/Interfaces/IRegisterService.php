<?php

namespace App\Http\Services\Interfaces;


use App\Entities\User;
use App\Repositories\Interfaces\IUserRepository;

interface IRegisterService
{
    public function __construct(IUserRepository $userRepository);

    public function insert(User $user);

}