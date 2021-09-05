<?php

use App\Laravue\Models\Animal;
use App\Laravue\Models\Specie;
use App\Laravue\Models\Breed;
use App\Laravue\Models\Client;
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
            'name' => 'Admin',
            'email' => 'admin@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $user = User::create([
            'name' => 'User',
            'email' => 'user@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);
        $visitor = User::create([
            'name' => 'Visitor',
            'email' => 'visitor@laravue.dev',
            'password' => Hash::make('laravue'),
        ]);

        //
        Breed::create([
            'name' => 'Dalmata',
        ]);

        Breed::create([
            'name' => 'Boxer',
        ]);

        Animal::create([
            'name' => 'Perro Cripto',
            'breed_id' => 1,
            'observation' => 'Es un perrito chevere',
        ]);

        Animal::create([
            'name' => 'Perro ',
            'breed_id' => 1,
            'observation' => 'Es un perrito no tan chevere',
        ]);

        Animal::create([
            'name' => 'Perro Traviezo',
            'breed_id' => 1,
            'observation' => 'Es un perrito malo',
            'status' => 0
        ]);

        Client::create([
            'first_name' => 'Super',
            'last_name' => 'Man',
            'document_type' => '**',
            'document_number' => '001',
            'phone' => '00123',
            'direction' => '001',
            'email' => '001',
            'status' => '001',
        ]);

        Specie::create([
            'name' => 'gato',
            'status' => 1,
        ]);

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $managerRole = Role::findByName(\App\Laravue\Acl::ROLE_MANAGER);
        $editorRole = Role::findByName(\App\Laravue\Acl::ROLE_EDITOR);
        $userRole = Role::findByName(\App\Laravue\Acl::ROLE_USER);
        $visitorRole = Role::findByName(\App\Laravue\Acl::ROLE_VISITOR);
        $admin->syncRoles($adminRole);
        $manager->syncRoles($managerRole);
        $editor->syncRoles($editorRole);
        $user->syncRoles($userRole);
        $visitor->syncRoles($visitorRole);
        $this->call(UsersTableSeeder::class);
    }
}
