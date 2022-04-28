<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

class PopulateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'title'       => 'Admin',
        ]);

        Role::create([
            'title'       => 'User',
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
