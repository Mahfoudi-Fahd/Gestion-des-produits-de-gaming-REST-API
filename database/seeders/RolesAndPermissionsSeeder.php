<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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


        // create permissions

        $editMyProfil = 'edit my profil';
        $editAllProfiles = 'edit all profiles';
        $deleteMyProfil = 'delete my profil';
        $deleteAllProfiles = 'delete all profiles';
        $viewMyprofil = 'view my profil';
        $viewAllprofil = 'view all profil';

        $addProduct = 'add product';
        $editAllProducts = 'edit All products';
        $editMyProduct = 'edit My product';
        $deleteAllProducts = 'delete All products';
        $deleteMyProduct = 'delete My product';

        $addCategory = 'add category';
        $editCategory = 'edit category';
        $deleteCategory = 'delete category';
        $viewCategory = 'view category';

        $giveRole = 'give role';
        $removeRole = 'remove role';
      
        $givePermission = 'give permission';
        $removePermission = 'remove permission';

        Permission::create(['name' => $editMyProfil]);
        Permission::create(['name' => $editAllProfiles]);
        Permission::create(['name' => $deleteMyProfil]);
        Permission::create(['name' => $deleteAllProfiles]);
        Permission::create(['name' => $viewMyprofil]);
        Permission::create(['name' => $viewAllprofil]);

        Permission::create(['name' => $addProduct]);
        Permission::create(['name' => $editAllProducts]);
        Permission::create(['name' => $editMyProduct]);
        Permission::create(['name' => $deleteAllProducts]);
        Permission::create(['name' => $deleteMyProduct]);

        Permission::create(['name' => $addCategory]);
        Permission::create(['name' => $editCategory]);
        Permission::create(['name' => $deleteCategory]);
        Permission::create(['name' => $viewCategory]);

        Permission::create(['name' => $giveRole]);
        Permission::create(['name' => $removeRole]);
        Permission::create(['name' => $givePermission]);
        Permission::create(['name' => $removePermission]);

    // Define roles available
        $admin = 'admin';
        $seller = 'seller';
        $user = 'user';

        // create roles and assign created permissions
        
        Role::create(['name' => $admin])->givePermissionTo(Permission::all());

        Role::create(['name' => $seller])->givePermissionTo([
            $addProduct,
            $editMyProduct,
            $deleteMyProduct,
            $editMyProfil,
            $deleteMyProfil,
            $viewMyprofil,
        ]);

        Role::create(['name' => $user])->givePermissionTo([
            $editMyProfil,
            $deleteMyProfil,
            $viewMyprofil,
        ]);
    }
}
