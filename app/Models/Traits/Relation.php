<?php

namespace App\Models\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

trait Relation
{
    private $permissions = [
        'access',
        'create',
        'edit',
        'delete',
        'show'
    ];

    public function touchPermission($table)
    {
        $role = Role::where('title', 'Admin')->first();

        if ($role) {
            foreach ($this->permissions as $permission) {
                $exist_permission = Permission::where('title', $table . '_' . $permission)->first();
                if (!$exist_permission) {
                    $new_permission = Permission::create([
                        'title' => $table . '_' . $permission
                    ]);

                    DB::table('permission_role')->insert(
                        array(
                            'role_id'         =>   $role->id,
                            'permission_id'   =>   $new_permission->id
                        )
                    );
                }
            }
        }
    }
}
