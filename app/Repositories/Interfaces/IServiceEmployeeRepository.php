<?php

namespace App\Repositories\Interfaces;


use App\Entities\EmployeeService;

interface IServiceEmployeeRepository
{
    public function __construct();

    public function get();

    public function getById($id);

    public function insert(EmployeeService $employeeService);

    public function update(EmployeeService $employeeService);

    public function delete($id);
}