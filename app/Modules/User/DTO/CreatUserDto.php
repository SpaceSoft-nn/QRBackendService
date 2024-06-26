<?php

namespace App\Modules\User\DTO;
use Illuminate\Contracts\Support\Arrayable;

class CreatUserDTO implements Arrayable
{

    public function __construct(

        public readonly ?string $email,

        public readonly ?string $phone,

        public readonly ?string $password,

        public readonly ?string $personal_area_id = null,

        public readonly ?string $role = null,

    ) {

    }

    public function inMailOrPhone()
    {

    }

    public function toArray(): array {

        return [
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }

}
