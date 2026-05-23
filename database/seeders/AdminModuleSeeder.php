<?php

namespace Database\Seeders;

use App\Models\AuditActions;
use App\Models\CustomerTypes;
use App\Models\MovementTypes;
use App\Models\PaymentMethods;
use App\Models\PaymentStatuses;
use App\Models\Permissions;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminModuleSeeder extends Seeder
{
    /**
     * 
     */
    public function run(): void
    {
        $role = Roles::firstOrCreate(
            ['code' => 'ADMIN'],
            [
                'name' => 'Administrator',
                'isActive' => true,
                'createdBy' => 1,
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@proyectoafe.com'],
            [
                'roleId' => $role->id,
                'name' => 'System Admin',
                'password' => 'admin123',
                'isActive' => true,
                'createdBy' => 1,
            ]
        );

        foreach ([
            ['name' => 'Individual', 'code' => 'IND'],
            ['name' => 'Company', 'code' => 'COMP'],
        ] as $row) {
            CustomerTypes::firstOrCreate(
                ['code' => $row['code']],
                ['name' => $row['name'], 'isActive' => true, 'createdBy' => 1]
            );
        }

        foreach ([
            ['name' => 'Stock In', 'code' => 'IN'],
            ['name' => 'Stock Out', 'code' => 'OUT'],
            ['name' => 'Adjustment', 'code' => 'ADJ'],
            ['name' => 'Return', 'code' => 'RET'],
        ] as $row) {
            MovementTypes::firstOrCreate(
                ['code' => $row['code']],
                ['name' => $row['name'], 'isActive' => true, 'createdBy' => 1]
            );
        }

        foreach ([
            ['name' => 'Pending', 'code' => 'PEND'],
            ['name' => 'Paid', 'code' => 'PAID'],
            ['name' => 'Partial', 'code' => 'PART'],
            ['name' => 'Cancelled', 'code' => 'CANC'],
        ] as $row) {
            PaymentStatuses::firstOrCreate(
                ['code' => $row['code']],
                ['name' => $row['name'], 'isActive' => true, 'createdBy' => 1]
            );
        }

        foreach ([
            ['name' => 'Cash', 'code' => 'CASH'],
            ['name' => 'Credit Card', 'code' => 'CARD'],
            ['name' => 'Bank Transfer', 'code' => 'TRANS'],
            ['name' => 'Credit', 'code' => 'CRED'],
        ] as $row) {
            PaymentMethods::firstOrCreate(
                ['code' => $row['code']],
                ['name' => $row['name'], 'isActive' => true, 'createdBy' => 1]
            );
        }

        foreach ([
            ['name' => 'Insert', 'code' => 'INS'],
            ['name' => 'Update', 'code' => 'UPD'],
            ['name' => 'Delete', 'code' => 'DEL'],
        ] as $row) {
            AuditActions::firstOrCreate(
                ['code' => $row['code']],
                ['name' => $row['name'], 'isActive' => true, 'createdBy' => 1]
            );
        }

        foreach ([
            ['name' => 'Admin Module',     'code' => 'ADMIN_MOD'],
            ['name' => 'CRM Module',       'code' => 'CRM_MOD'],
            ['name' => 'Inventory Module', 'code' => 'INV_MOD'],
            ['name' => 'Billing Module',   'code' => 'BILL_MOD'],
            ['name' => 'Reports Module',   'code' => 'REP_MOD'],
        ] as $row) {
            Permissions::firstOrCreate(
                ['code' => $row['code']],
                ['name' => $row['name'], 'isActive' => true, 'createdBy' => 1]
            );
        }

        $ids = Permissions::pluck('id');
        $role->permissions()->sync($ids);
    }
}
