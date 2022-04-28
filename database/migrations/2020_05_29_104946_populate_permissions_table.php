<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class PopulatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::create([
            'title'       => 'permissions_create',
        ]);

        Permission::create([
            'title'       => 'permissions_edit',
        ]);

        Permission::create([
            'title'       => 'permissions_show',
        ]);

        Permission::create([
            'title'       => 'permissions_delete',
        ]);

        Permission::create([
            'title'       => 'permissions_access',
        ]);

        Permission::create([
            'title'       => 'user_create',
        ]);

        Permission::create([
            'title'       => 'user_edit',
        ]);

        Permission::create([
            'title'       => 'user_show',
        ]);

        Permission::create([
            'title'       => 'user_delete',
        ]);

        Permission::create([
            'title'       => 'user_access',
        ]);

        Permission::create([
            'title'       => 'roles_create',
        ]);

        Permission::create([
            'title'       => 'roles_edit',
        ]);

        Permission::create([
            'title'       => 'roles_show',
        ]);

        Permission::create([
            'title'       => 'roles_delete',
        ]);

        Permission::create([
            'title'       => 'roles_access',
        ]);

        Permission::create([
            'title'       => 'translations_access',
        ]);

        Permission::create([
            'title'       => 'variable_create',
        ]);

        Permission::create([
            'title'       => 'variable_edit',
        ]);

        Permission::create([
            'title'       => 'variable_delete',
        ]);

        Permission::create([
            'title'       => 'variable_access',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
