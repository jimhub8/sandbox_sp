<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create users
        Permission::create(['guard_name' => 'web', 'name' =>  'filter by country']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete users']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit users']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create users']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view users']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create subscribers']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete subscribers']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view subscribers']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view shipments']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete shipments']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create shipments']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit shipments']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit subscriber']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit scan']);
        Permission::create(['guard_name' => 'web', 'name' =>  'inscan']);
        Permission::create(['guard_name' => 'web', 'name' =>  'outscan']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view branches']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create branches']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit branches']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete branches']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create roles']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view roles']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete roles']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit roles']);
        Permission::create(['guard_name' => 'web', 'name' =>  'upload excel']);
        Permission::create(['guard_name' => 'web', 'name' =>  'assign']);
        Permission::create(['guard_name' => 'web', 'name' =>  'update status']);
        Permission::create(['guard_name' => 'web', 'name' =>  'single print']);
        Permission::create(['guard_name' => 'web', 'name' =>  'shipment status']);
        Permission::create(['guard_name' => 'web', 'name' =>  'update charges']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view finance']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view reports']);
        Permission::create(['guard_name' => 'web', 'name' =>  'Filter Shipments']);
        Permission::create(['guard_name' => 'web', 'name' =>  'update delivered']);
        Permission::create(['guard_name' => 'web', 'name' =>  'update dispatched']);
        Permission::create(['guard_name' => 'web', 'name' =>  'update returned']);
        Permission::create(['guard_name' => 'web', 'name' =>  'print waybill']);
        Permission::create(['guard_name' => 'web', 'name' =>  'filter by client']);
        Permission::create(['guard_name' => 'web', 'name' =>  'send sms']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view logs']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view screen']);

        // Permission::create(['guard_name' => 'clients', 'name' =>  'view shipments']);

        // create Super admin
        $role = Role::create(['guard_name' => 'web', 'name' => 'Super admin']);
        $role->givePermissionTo(Permission::all());

        // this can be done as separate statements
        // $role = Role::create(['guard_name' => 'web', 'name' => 'Admin']);
        // $role->givePermissionTo('view users');

        // $role = Role::create(['guard_name' => 'clients', 'name' => 'Client']);
        // $role->givePermissionTo('view orders');

        $user = new User();
        $user->password = Hash::make('password');
        $user->name = 'Jimmy';
        $user->email = 'jimlaravel@gmail.com';
        $user->phone = '0700000000';
        $user->address = 'Nairobi, Kenya';
        $user->city = 'Nairobi';
        $user->country_id = 1;
        $user->save();
        $user->assignRole('Super admin');
    }
}
