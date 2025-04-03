<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 18-10-21
 * Time: 3.16.MD
 */

namespace App\Http\Services\Implementations;


use App\Entities\Payment;
use App\Http\Services\Interfaces\IPaymentService;
use App\Repositories\Interfaces\IPaymentRepository;

class PaymentService implements IPaymentService
{
    protected $serviceRepository;

    public function __construct(IPaymentRepository $paymentRepository)
    {
        $this->paymentRepository =  $paymentRepository;
    }

    public function get()
    {
        return $this->paymentRepository->get();
    }

    public function getById($id)
    {
        return $this->paymentRepository->getById($id);
    }

    public function insert(Payment $payment)
    {
        return $this->paymentRepository->insert($payment);
    }

    public function update(Payment $payment)
    {
        return $this->paymentRepository->update($payment);
    }

    public function delete($id)
    {
        return $this->paymentRepository->delete($id);
    }

}