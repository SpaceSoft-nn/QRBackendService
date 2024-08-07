<?php

namespace App\Modules\Currencies\Source;

use App\Helpers\Values\AmountValue;
use App\Modules\Currencies\Source\Enums\SourceEnum;
use App\Modules\Currencies\Source\Interface\Source;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CbrfSource implements Source
{
    public function getPrices(): Collection
    {
        $date = Carbon::create(now()->year , now()->month, now()->day);

        $date = $date->format('d.m.Y');

        $date = Str::replace('-', '/' , $date);

        // dd("https://cbr.ru/scripts/XML_daily.asp?date_req={$date}");

        $response = file_get_contents("https://cbr.ru/scripts/XML_daily.asp?date_req={$date}");

        $response = simplexml_load_string($response);

        $response = json_encode($response);

        $response = json_decode($response);

        $prices = new Collection([]);

        foreach ($response->Valute as $data){

            $value = new AmountValue(Str::replace(',', '.' , $data->VunitRate));

            $prices->push(new SourcePrice(

                currency: $data->CharCode,

                value: $value,

            ));

        }

        return $prices;
    }

    public function enum(): SourceEnum
    {
        return SourceEnum::cbrf;
    }
}
