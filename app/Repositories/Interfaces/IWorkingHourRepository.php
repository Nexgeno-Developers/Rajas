<?php

namespace App\Repositories\Interfaces;


use App\Entities\WorkingHour;

interface IWorkingHourRepository
{
    public function __construct();

    public function get();

    public function getById($id);

    public function insert(WorkingHour $workingHour);

    public function update(WorkingHour $workingHour);

    public function delete($id);
}