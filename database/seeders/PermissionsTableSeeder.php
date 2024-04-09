<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
