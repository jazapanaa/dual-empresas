<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ad = Role::create(['name' => 'administrator']);
        $ga = Role::create(['name' => 'General Administrator']);//Administrador General
        $is = Role::create(['name' => 'Inventory Supervisor']);//Supervisor de Inventario
        $wm = Role::create(['name' => 'Warehouse Manager']);//Gerente de Almacén
        $wc = Role::create(['name' => 'Warehouse Clerk']);//Almacenista
        $sm = Role::create(['name' => 'Sales Manager']);//Gerente de ventas
        $sc = Role::create(['name' => 'Sales Clerk']);//Vendedor
        $pm = Role::create(['name' => 'Purchasing Manager']);//Gerente de compras
        $pc = Role::create(['name' => 'Purchasing Clerk']);//Comprador
        $f = Role::create(['name' => 'Billing']);//Facturador

        Permission::create(['name' => 'menu administrator'])->syncRoles([$ad]);
        Permission::create(['name' => 'menu inventory supervisor'])->syncRoles([$ad,$ga,$is]);
        Permission::create(['name' => 'menu warehouse manager'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'menu warehouse clerk'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'menu billing'])->syncRoles([$ad,$ga,$f]);
        Permission::create(['name' => 'menu sales manager'])->syncRoles([$ad,$ga,$sm,$sc]);
        Permission::create(['name' => 'menu sales clerk'])->syncRoles([$ad,$ga,$sm,$sc]);
        Permission::create(['name' => 'menu purchasing manager'])->syncRoles([$ad,$ga,$pm,$pc]);
        Permission::create(['name' => 'menu purchasing clerk'])->syncRoles([$ad,$ga,$pm,$pc]);
        Permission::create(['name' => 'menu general administrator'])->syncRoles([$ad,$ga]);
        Permission::create(['name' => 'menu access'])->syncRoles([$ad,$ga,$wm,$is,$sm,$pm]);
        Permission::create(['name' => 'menu reports'])->syncRoles([$ad,$ga,$wm,$is,$sm,$pm]);
        Permission::create(['name' => 'menu company'])->syncRoles([$ad,$ga]);

        Permission::create(['name' => 'Consulta inventario'])->syncRoles([$ad,$ga,$is,$wm,$wc]);
        Permission::create(['name' => 'Realiza ingreso'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'consulta ingreso'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Realiza egreso'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Consulta egreso'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Gestiona productos'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Consulta productos'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Gestiona proveedores'])->syncRoles([$ad,$ga,$sm,$sc]);
        Permission::create(['name' => 'Consulta proveedores'])->syncRoles([$ad,$ga,$sm,$sc]);
        Permission::create(['name' => 'Gestiona usuarios'])->syncRoles([$ad,$ga,$is,$wm,$sm,$pm]);
        Permission::create(['name' => 'Consulta usuarios'])->syncRoles([$ad,$ga,$is,$wm,$sm,$pm]);
        Permission::create(['name' => 'Gestiona roles'])->syncRoles([$ad,$ga]);
        Permission::create(['name' => 'Consulta roles'])->syncRoles([$ad,$ga,$wm,$is,$sm,$pm]);
        Permission::create(['name' => 'Gestiona permisos'])->syncRoles([$ad,$ga]);
        Permission::create(['name' => 'Consulta permisos'])->syncRoles([$ad,$ga,$wm,$is,$sm,$pm]);
        Permission::create(['name' => 'Gestiona almacenes'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Consulta almacenes'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Gestiona categorias'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Consulta categorias'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Gestiona unidades'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Consulta unidades'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Gestiona tipo de movimiento'])->syncRoles([$ad,$ga,$wm,$wc]);
        Permission::create(['name' => 'Consulta tipo de movimiento'])->syncRoles([$ad,$ga,$wm,$wc]);

        Permission::create(['name' => 'Realiza ventas'])->syncRoles([$ad,$ga,$sm,$sc]);
        Permission::create(['name' => 'Consulta ventas'])->syncRoles([$ad,$ga,$sm,$sc]);
        Permission::create(['name' => 'Gestiona clientes'])->syncRoles([$ad,$ga,$sm,$sc]);
        Permission::create(['name' => 'Consulta clientes'])->syncRoles([$ad,$ga,$sm,$sc]);

        Permission::create(['name' => 'Realiza compras'])->syncRoles([$ad,$ga,$pm,$pc]);
        Permission::create(['name' => 'Consulta compras'])->syncRoles([$ad,$ga,$pm,$pc]);

    }
}
