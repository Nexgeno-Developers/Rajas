<?php


namespace App\Http\Services\Interfaces;

use App\Entities\Payment;
use App\Repositories\Interfaces\IPaymentRepository;

interface IPaymentService
{
    public function __construct(IPaymentRepository $paymentRepository);

    public function get();

    public function getById($id);

    public function insert(Payment $payment);

    public function update(Payment $payment);

    public function delete($id);
}