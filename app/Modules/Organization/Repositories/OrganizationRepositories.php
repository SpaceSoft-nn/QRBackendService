<?php
namespace App\Modules\Organization\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Organization\Models\Organization as Model;
use App\Modules\User\Models\User;

class OrganizationRepositories extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Возращает все организации которые относятся к User
     * @return Model|null
     */
    public function getOrganization(User $user) : \Illuminate\Database\Eloquent\Collection
    {
        $model = $this->query()
            ->where('owner_id' , '=' , $user->id)
            ->get();

        return $model;
    }
}
