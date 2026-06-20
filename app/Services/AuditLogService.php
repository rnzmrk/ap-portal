<?php

namespace App\Services;

use App\Models\AuditLogs;

class AuditLogService
{
    public function log(
        int $userId,
        string $module,
        string $action,
        int $recordId,
        array $oldValues = [],
        array $newValues = []
    ): void {
        AuditLogS::create([
            'user_id' => $userId,
            'module' => $module,
            'action' => $action,
            'record_id' => $recordId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }
}
