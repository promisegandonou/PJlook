<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Fonction;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage_app']);
        Permission::create(['name' => 'invite_member']);
        Permission::create(['name' => 'add_project_task']);
        Permission::create(['name' => 'manage_project_task']);
        Permission::create(['name' => 'assign_project_task']);
        Permission::create(['name' => 'show_project_task']);


        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('manage_app');
        $role1->givePermissionTo('manage_project_task');
        $role1->givePermissionTo('assign_project_task');
        $role1->givePermissionTo( 'invite_member');
        $role1->givePermissionTo('show_project_task');

        //$role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'Chef Projet']);
        $role2->givePermissionTo('invite_member');
        $role2->givePermissionTo('manage_project_task');
        $role2->givePermissionTo('assign_project_task');
        $role2->givePermissionTo('show_project_task');


       $role3 = Role::create(['name' => 'Chef Projet adjoint']);
       $role3->givePermissionTo('assign_project_task');
       $role3->givePermissionTo('manage_project_task');
       $role3->givePermissionTo('show_project_task');

       $role4 = Role::create(['name' => 'membre']);
       $role4->givePermissionTo('show_project_task');




        // create demo users
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password'=>Hash::make('password')
        ]);
        $user->assignRole($role1);

        $ChefPro = Fonction::create([
            'libelle' => 'Chef Projet',
        ]);
        $ChefPro->assignRole($role2);

        $ChefProAdj= Fonction::create([
            'libelle' => 'Chef Projet Adjoint',
        ]);
        $ChefProAdj->assignRole($role3);

        $membre= Fonction::create([
            'libelle' => 'membre',
        ]);
        $membre->assignRole($role4);

       
//
    }
}
