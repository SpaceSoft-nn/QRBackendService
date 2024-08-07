<?php

namespace App\Modules\Payment\Action;

use App\Modules\Payment\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetPaymentMethodsAction{


    private string|null $currency = null;

    private bool|null $active = true;

    private int|null $id = null;

    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function id(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function active(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    private function query(): Builder
    {
        $query = PaymentMethod::query();

        if( !is_null($this->currency) ){

            $query->where('driver_currency_id', $this->currency);

        }

        if( !is_null($this->active) ){

            $query->where('active', $this->active);

        }

        if( !is_null($this->id) )
        {
            $query->where('id', $this->id);
        }


        return $query;
    }




    public function first(): PaymentMethod|null
    {
        /**
         * @var Builder $query
         */

        $query = $this->query();
        
        return $query->first();
    }

    public function get(): Collection|null
    {
        //Вернуть все способы оплаты где action = true

         /**
         * @var Builder $query
         */

        $query = $this->query();

        return $query->get();
    }


}



