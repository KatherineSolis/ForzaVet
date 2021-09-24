<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Laravue\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Carlos Suarez Vargas',
            'email' => 'carlos.suarezv@outlook.com',
            'password' => Hash::make('laravue@2021'),
        ]);

        $veterinario1 = User::create([
            'name' => 'Erika Gonzales',
            'email' => 'erika90_gzl@gmail.com',
            'password' => Hash::make('eg_2021!G90'),
        ]);
        $veterinario2 = User::create([
            'name' => 'Bianca Alvear ',
            'email' => 'bianca.alvear98@hotmail.com',
            'password' => Hash::make('webrtc_bls'),
        ]);
        $veterinario3 = User::create([
            'name' => 'Bryan Tejada',
            'email' => 'btejada97@outlook.com',
            'password' => Hash::make('btejada_97'),
        ]);

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $veterinarioRole = Role::findByName(\App\Laravue\Acl::ROLE_VETERINARY);
        $admin->syncRoles($adminRole);
        $veterinario1->syncRoles($veterinarioRole);
        $veterinario2->syncRoles($veterinarioRole);
        $veterinario3->syncRoles($veterinarioRole);
        //$this->call(UsersTableSeeder::class);
    }
}
