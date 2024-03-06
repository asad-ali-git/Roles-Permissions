<?php

namespace App\Models;

use App\Models\Scopes\SuperAdminRoleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new SuperAdminRoleScope);
    }

    const ROLE_SUPER_ADMIN = 'super-admin';

    const ROLE_STATUS_ACTIVE = 'active';

    const ROLE_STATUS_DISABLED = 'disabled';

    public static function statuses()
    {
        return [
            self::ROLE_STATUS_ACTIVE => 'Active',
            self::ROLE_STATUS_DISABLED => 'Disabled',
        ];
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
