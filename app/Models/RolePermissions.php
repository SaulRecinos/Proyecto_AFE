<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermissions extends Pivot
{
    protected $table = 'rolePermissions';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'roleId',
        'permissionId',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Roles::class, 'roleId');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permissions::class, 'permissionId');
    }
}
