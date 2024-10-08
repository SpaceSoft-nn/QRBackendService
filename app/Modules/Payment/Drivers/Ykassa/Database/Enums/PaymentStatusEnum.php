<?php

namespace App\Modules\Payment\Drivers\Ykassa\Database\Enums;

enum PaymentStatusEnum: string
{
    case pending = 'pending';

    case waiting_for_capture = 'waiting_for_capture';

    case succeeded  = 'succeeded';

    case canceled = 'canceled';

    public static function stringToObject(string $name) : static
    {
        return match($name){

            'succeeded' => PaymentStatusEnum::succeeded,

            'waiting_for_capture' => PaymentStatusEnum::waiting_for_capture,

            'canceled' => PaymentStatusEnum::canceled,

        };
    }

    // public function name(): string
    // {
    //     return match($this){

    //         self::pending => 'Ожидает',

    //         self::completed => 'Завершено',

    //         self::cancelled => 'Отменено',

    //     };
    // }

    // public function color(): string
    // {
    //     return match($this){

    //         self::pending => 'warning',

    //         self::completed => 'success',

    //         self::cancelled => 'danger',

    //     };
    // }

    private function is(PaymentStatusEnum $status): bool
    {

        return $this === $status;
    }

    public function isPending(): bool
    {

        return $this->is(PaymentStatusEnum::pending);
    }

    public function isCompleted(): bool
    {

        return $this->is(PaymentStatusEnum::succeeded);
    }

    public function isCancelled(): bool
    {

        return $this->is(PaymentStatusEnum::canceled);
    }

}
