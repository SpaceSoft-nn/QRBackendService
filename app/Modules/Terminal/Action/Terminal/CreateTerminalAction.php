<?php

namespace App\Modules\Terminal\Action\Terminal;

use App\Modules\Organization\Models\Organization;
use App\Modules\Terminal\Models\Terminal;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateTerminalAction
{
    public static function run(Organization $organization, string $name) : Terminal
    {

            $terminal = Terminal::create([
                'organization_id' => $organization->id,
                'name' => $name,
            ]);


        if(!$terminal->save()){
            throw new ModelNotFoundException('Не удалось создать терминал.', 500);
        }

        return $terminal;
    }
}
