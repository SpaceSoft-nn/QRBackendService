<?php

namespace App\Modules\Payment\Events\DTO;

use App\Modules\Payment\Models\Payment;

trait TraitPaymentData
{
    //таким способом можно не вызывать создание экземпляра из вне
    public static function fromPayment(Payment $payment): static
    {
        return new static(
            uuid: $payment->uuid,

            payableType: $payment->payable_type,

            payableId: $payment->payable_id,
        );
    }

}
