<?php

namespace App\Repositories\Interfaces;


use App\Entities\Appointment;

interface IAppointmentRepository
{
    public function __construct();

    public function get();

    public function getById($id);

    public function insert(Appointment $appointment);

    public function update(Appointment $appointment);

    public function delete($id);
}