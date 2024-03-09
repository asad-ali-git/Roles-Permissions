<?php

namespace App\Models;

use App\Models\Scopes\SuperAdminUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // static::addGlobalScope(new SuperAdminUserScope);
    }

    const SUPER_ADMIN_NAME = 'Super Admin';
    const SUPER_ADMIN_EMAIL = 'superadmin@gmail.com';

    const USER_STATUS_ACTIVE = 'active';

    const USER_STATUS_DISABLED = 'disabled';

    public static function userStatuses()
    {
        return [
            self::USER_STATUS_ACTIVE => 'Active',
            self::USER_STATUS_DISABLED => 'Disabled',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
