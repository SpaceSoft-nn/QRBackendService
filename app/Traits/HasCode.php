<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

use function App\Helpers\code;

trait HasCode
{
    public static function booted(): void
    {
        self::creating( function(Model $model) {

            $model->code = code();

        });
    }
}
