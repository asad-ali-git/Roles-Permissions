<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    const PERMISSION_STATUS_ACTIVE = 'active';

    const PERMISSION_STATUS_DISABLED = 'disabled';

    public static function permissionStatuses()
    {
        return [
            self::PERMISSION_STATUS_ACTIVE => 'Active',
            self::PERMISSION_STATUS_DISABLED => 'Disabled',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
