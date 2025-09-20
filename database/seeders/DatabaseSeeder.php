<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Unit;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Criar unidades de medida
        $units = [
            ['name' => 'Unidade', 'abbreviation' => 'UN', 'type' => 'unit'],
            ['name' => 'Quilograma', 'abbreviation' => 'KG', 'type' => 'weight'],
            ['name' => 'Litro', 'abbreviation' => 'L', 'type' => 'volume'],
            ['name' => 'Metro', 'abbreviation' => 'M', 'type' => 'length'],
            ['name' => 'Caixa', 'abbreviation' => 'CX', 'type' => 'unit'],
            ['name' => 'Grade', 'abbreviation' => 'GRD', 'type' => 'unit'],
            ['name' => 'Fardo', 'abbreviation' => 'FAR', 'type' => 'unit'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }

        // Criar permissões
        $permissions = [
            'manage_products', 'manage_orders', 'view_reports',
            'manage_stock', 'pos_access', 'manage_users',
            'manage_company', 'manage_branches'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Criar roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $supervisorRole = Role::create(['name' => 'supervisor']);
        $sellerRole = Role::create(['name' => 'seller']);
        $customerRole = Role::create(['name' => 'customer']);

        // Atribuir permissões às roles
        $adminRole->givePermissionTo(Permission::all());
        
        $managerRole->givePermissionTo([
            'manage_products', 'manage_orders', 'view_reports',
            'manage_stock', 'pos_access', 'manage_users'
        ]);
        
        $supervisorRole->givePermissionTo([
            'manage_orders', 'view_reports', 'manage_stock', 'pos_access'
        ]);
        
        $sellerRole->givePermissionTo(['pos_access']);

        // Criar empresa de exemplo
        $company = Company::create([
            'name' => 'Empresa Exemplo Lda',
            'tax_id' => '123456789',
            'type' => 'company',
            'email' => 'exemplo@empresa.com',
            'phone' => '+244 123 456 789',
            'address' => 'Luanda, Angola',
            'is_active' => true
        ]);

        // Criar filial principal
        $branch = Branch::create([
            'company_id' => $company->id,
            'name' => 'Filial Central',
            'code' => 'FC001',
            'address' => 'Luanda, Angola',
            'default_tax_rate' => 14.00,
            'is_main' => true,
            'is_active' => true
        ]);

        // Criar armazém principal
        $branch->warehouses()->create([
            'name' => 'Armazém Principal',
            'code' => 'AMP001',
            'type' => 'main',
            'is_active' => true
        ]);

        // Criar utilizador admin
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@pregao.com',
            'password' => bcrypt('password'),
            'company_id' => $company->id,
            'branch_id' => $branch->id
        ]);

        $admin->assignRole('admin');

        // Criar limites de venda padrão
        $branch->saleLimits()->create([
            'max_lines' => 100,
            'max_quantity_per_line' => 1000,
            'max_total_amount' => 1000000,
            'max_total_quantity' => 10000,
            'action' => 'warn',
            'is_active' => true
        ]);

        $this->command->info('Dados iniciais criados com sucesso!');
        $this->command->info('Email: admin@pregao.com');
        $this->command->info('Password: password');
    }
}