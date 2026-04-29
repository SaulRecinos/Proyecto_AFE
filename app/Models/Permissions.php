<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permissions extends Model
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Roles::class, 'rolePermissions', 'permissionId', 'roleId')
            ->withTimestamps(false, false);
    }
}
