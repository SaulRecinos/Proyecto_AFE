<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roles extends Model
{
    public const CREATED_AT = 'createdAt';

    public const UPDATED_AT = 'updatedAt';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'isActive',
        'createdBy',
        'updatedBy',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'isActive' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'roleId');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permissions::class, 'rolePermissions', 'roleId', 'permissionId')
            ->withTimestamps(false, false);
    }
}
