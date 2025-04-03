<?php

namespace App\Repositories\Interfaces;


use App\Entities\Payment;

interface IPaymentRepository
{
    public function __construct();

    public function get();

    public function getById($id);

    public function insert(Payment $payment);

    public function update(Payment $payment);

    public function delete($id);
}