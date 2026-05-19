<?php

namespace App\Http\Controllers\Concerns;

trait ErpControllerHelpers
{
    protected function actorId(): int
    {
        return (int) (auth()->id() ?? 1);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function withAuditOnCreate(array $data): array
    {
        $actor = $this->actorId();

        return array_merge($data, [
            'createdBy' => $actor,
            'updatedBy' => $actor,
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function withAuditOnUpdate(array $data): array
    {
        return array_merge($data, [
            'updatedBy' => $this->actorId(),
        ]);
    }
}
