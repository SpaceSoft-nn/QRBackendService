<?php


namespace App\Modules\User\Models;

use App\Modules\Base\Enums\ActiveStatusEnum;
use App\Modules\Notification\Models\Notification;
use App\Modules\Notification\Traits\HasUuid;
use App\Modules\Payment\Models\DriverInfo;
use App\Modules\Terminal\Models\Terminal;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Modules\User\Enums\RoleUserEnum;
use App\Modules\User\Observers\UserObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([UserObserver::class])] // наблюдатель p.s не акутально можно убрать (оставил для примера)
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasUuid;
    protected $fillable = [

        'phone',
        'email',
        'password',

        'first_name',
        'last_name',
        'father_name',

        'email_confirmed_at',
        'phone_confirmed_at',

        'password',
        'personal_area_id',

    ];

    protected $guarded = [
        'uuid',
        'role',
        'active',
        'auth',
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'auth' => 'boolean',
        'active' => 'boolean',
        'password' => 'hashed',
        'role' => RoleUserEnum::class,
        'email_confirmed_at' => 'datetime',
        'phone_confirmed_at' => 'datetime',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function driverinfo(): HasMany
    {
        return $this->hasMany(DriverInfo::class);
    }

    public function terminal(): HasMany
    {
        return $this->hasMany(Terminal::class);
    }

    public function notifycation(): HasMany
    {
        return $this->hasMany(Notification::class);
    }


    public function lastNotify() : HasMany
    {
        return $this->hasMany(Notification::class);
    }

    //возвращает последнию нотификацию (по значению нотификации и статусу)
    public function lastNotifyAndPending()
    {
        return $this->lastNotify()
            ->where('value', $this->value)
            ->where('status', ActiveStatusEnum::pending);
    }

    public function lastNotifyAndCompleted()
    {
        return $this->lastNotify()
            ->where('value', $this->value)
            ->where('status', ActiveStatusEnum::completed);
    }

}
