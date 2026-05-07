<?php

namespace Database\Seeders;

use App\Models\Unidade;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $registroId = Unidade::query()->where('nome', 'Senac Registro')->value('id');

        $roles = ['super_admin', 'admin_unidade', 'operador', 'estudante'];

        foreach ($roles as $role) {
            Role::findOrCreate($role);
        }

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@senac.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'unidade_id' => $registroId,
            ]
        );

        if ($superAdmin->unidade_id === null) {
            $superAdmin->unidade_id = $registroId;
            $superAdmin->save();
        }

        if (! $superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole('super_admin');
        }

        $unitAdmin = User::firstOrCreate(
            ['email' => 'admin.unidade@senac.test'],
            [
                'name' => 'Admin Unidade Registro',
                'password' => Hash::make('password'),
                'unidade_id' => $registroId,
            ]
        );

        if ($unitAdmin->unidade_id === null) {
            $unitAdmin->unidade_id = $registroId;
            $unitAdmin->save();
        }

        if (! $unitAdmin->hasRole('admin_unidade')) {
            $unitAdmin->assignRole('admin_unidade');
        }
    }
}
