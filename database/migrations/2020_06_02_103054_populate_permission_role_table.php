<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PopulatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role_admin = Role::where('title','Admin')->first();
        $user_admin = User::where('email','admin@admin.com')->first();

        $permissions = Permission::all();


        foreach ($permissions as $permission){
            DB::table('permission_role')->insert(
                array(
                    'role_id'     =>   $role_admin->id,
                    'permission_id'   =>   $permission->id
                )
            );
        }

        DB::table('role_user')->insert(
            array(
                'user_id'     =>   $user_admin->id,
                'role_id'   =>   $role_admin->id
            )
        );

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
