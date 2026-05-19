<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'auditLogs';

    public const CREATED_AT = 'createdAt';

    public const UPDATED_AT = null;

    /** @var list<string> */
    protected $fillable = [
        'userId',
        'auditActionId',
        'targetTable',
        'oldValue',
        'newValue',
        'ipAddress',
    ];

    protected function casts(): array
    {
        return [
            'oldValue' => 'array',
            'newValue' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function auditAction(): BelongsTo
    {
        return $this->belongsTo(AuditActions::class, 'auditActionId');
    }
}
