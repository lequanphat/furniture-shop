<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role = Role::create(['name' => 'Administrators']);
        $role->givePermissionTo([
            'read users',
            'create user',
            'update user',
            'delete user',
            'read categories',
            'create category',
            'update category',
            'delete category',
            'read brands',
            'create brand',
            'update brand',
            'delete brand',
            'read colors',
            'create color',
            'update color',
            'delete color',
            'read products',
            'create product',
            'update product',
            'delete product',
            'read discounts',
            'create discount',
            'update discount',
            'delete discount',
            'read orders',
            'create order',
            'update order',
            'delete order',
            'read receipts',
            'create receipt',
            'update receipt',
            'delete receipt',
            'read suppliers',
            'create supplier',
            'update supplier',
            'delete supplier',
            'read roles',
            'create role',
            'update role',
            'delete role'
        ]);
    }
}
