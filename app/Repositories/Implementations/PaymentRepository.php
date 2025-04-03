<?php

namespace App\Repositories\Implementations;


use App\Entities\Payment;
use App\Repositories\Interfaces\IPaymentRepository;

class PaymentRepository implements IPaymentRepository
{

    public function __construct()
    {
    }

    public function get()
    {
        return Payment::all();
    }

    public function getById($id)
    {
        return Payment::find($id);
    }

    public function insert(Payment $payment)
    {
       $payment->save();
       return $payment;
    }

    public function update(Payment $payment)
    {
        $payment->update();
        return $payment;
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }
}