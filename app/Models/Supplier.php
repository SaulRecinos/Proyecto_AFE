<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'suppliers';

    public const CREATED_AT = 'createdAt';

    public const UPDATED_AT = 'updatedAt';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'taxId',
        'contactName',
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplierId');
    }
}
