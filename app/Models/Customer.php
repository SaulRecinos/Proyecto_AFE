<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';

    public const CREATED_AT = 'createdAt';

    public const UPDATED_AT = 'updatedAt';

    /** @var list<string> */
    protected $fillable = [
        'customerTypeId',
        'fullName',
        'taxId',
        'email',
        'phoneNumber',
        'address',
        'isActive',
        'createdBy',
        'updatedBy',
    ];

    protected function casts(): array
    {
        return ['isActive' => 'boolean'];
    }

    public function customerType(): BelongsTo
    {
        return $this->belongsTo(CustomerTypes::class, 'customerTypeId');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'customerId');
    }
}
