<?php

namespace App\Services;

use App\Models\AuditActions;
use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log(string $actionCode, string $targetTable, ?array $oldValue = null, ?array $newValue = null): void
    {
        $action = AuditActions::query()->where('code', $actionCode)->first();
        if ($action === null) {
            return;
        }

        $userId = auth()->id();
        if ($userId === null) {
            return;
        }

        AuditLog::create([
            'userId' => $userId,
            'auditActionId' => $action->id,
            'targetTable' => $targetTable,
            'oldValue' => $oldValue,
            'newValue' => $newValue,
            'ipAddress' => Request::ip(),
        ]);
    }

    public static function logInsert(Model $model, string $targetTable): void
    {
        self::log('INS', $targetTable, null, $model->toArray());
    }

    public static function logUpdate(Model $model, string $targetTable, array $oldAttributes): void
    {
        self::log('UPD', $targetTable, $oldAttributes, $model->toArray());
    }

    public static function logDelete(Model $model, string $targetTable): void
    {
        self::log('DEL', $targetTable, $model->toArray(), null);
    }
}
