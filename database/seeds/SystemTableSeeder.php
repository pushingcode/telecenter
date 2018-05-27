<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed de Roles y permisos
     * Seed de informacion del sistema
     * @return void
     */
    public function run()
    {
        //
        $this->call('RolesAndPermissionsSeeder');
        $this->command->info('Roles y Permisos creados y cargados');
    }


}

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'crear admin']);
        Permission::create(['name' => 'editar admin']);
        Permission::create(['name' => 'eliminar admin']);
        Permission::create(['name' => 'activar admin']);
        Permission::create(['name' => 'desactivar admin']);

        Permission::create(['name' => 'crear tecnico']);
        Permission::create(['name' => 'editar tecnico']);
        Permission::create(['name' => 'eliminar tecnico']);
        Permission::create(['name' => 'activar tecnico']);
        Permission::create(['name' => 'desactivar tecnico']);

        Permission::create(['name' => 'crear reporte']);
        Permission::create(['name' => 'ver reporte']);
        Permission::create(['name' => 'eliminar reporte']);

        Permission::create(['name' => 'consultar orden']);
        Permission::create(['name' => 'consultar contrato']);



        // create roles and assign existing permissions
        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo([
            'crear admin',
            'editar admin',
            'eliminar admin',
            'activar admin',
            'desactivar admin',
            'crear tecnico',
            'editar tecnico',
            'eliminar tecnico',
            'activar tecnico',
            'desactivar tecnico',
            'crear reporte',
            'ver reporte',
            'eliminar reporte',
            'consultar orden',
        	'consultar contrato'
            ]);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'crear tecnico',
            'editar tecnico',
            'eliminar tecnico',
            'activar tecnico',
            'desactivar tecnico',
            'crear reporte',
            'ver reporte',
            'consultar orden',
        	'consultar contrato'
            ]);

        $role = Role::create(['name' => 'tecnico']);
        $role->givePermissionTo([
        	'consultar orden',
        	'consultar contrato'
        	]);

        


        $user = \App\User::find(1);
        
        $user->assignRole('superadmin');

        $user = \App\User::find(2);
        
        $user->assignRole('admin');

        //$role = Role::create(['name' => 'admin']);
        //$role->givePermissionTo(['publish articles', 'unpublish articles']);
    }
}