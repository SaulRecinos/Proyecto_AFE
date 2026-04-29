<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTypes extends Model
{
    protected $table = 'customerTypes';

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
}
