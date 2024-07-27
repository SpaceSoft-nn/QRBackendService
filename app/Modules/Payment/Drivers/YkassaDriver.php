<?php
namespace App\Modules\Payment\Drivers;

use App\Modules\Payment\Drivers\Ykassa\App\Actions\DTO\CreatePaymentData;
use App\Modules\Payment\Drivers\Ykassa\YkassaService;
use App\Modules\Payment\Interface\PaymentDriverInterface;
use App\Modules\Payment\Models\Payment;

class YkassaDriver implements PaymentDriverInterface
{
    public function __construct(

        private YkassaService $ykassaService,

    ) { }

    public function view(Payment $payment)
    {

        $ykassaPayment = $this->ykassaService->createPayment(
            new CreatePaymentData(
                value: $payment->driver_amount->value(),
                // currency: $payment->currency_id,
                currency: 'RUB', //Указано хардкодом т.к юмани работает только с рублями (зависит от субаккаунта в основном это RU сигмент)
                capture: false,
                idempotenceKey: $payment->uuid,
                returnUrl: route('payments.success', [ 'uuid' => $payment->uuid ]),
                description: "",
            )
        );

        // dd( $ykassaPayment);

        $payment->update(['driver_payment_id' => $ykassaPayment->id]);

        $ykassaPaymentUrl = $ykassaPayment->url;


    }
}
