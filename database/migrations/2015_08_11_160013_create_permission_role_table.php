<?php

use Escape\Argon\Auth\PermissionGrant;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('permission');
            $table->integer('role_id');
            $table->timestamps();
        });

        $grant = new PermissionGrant();
        $grant->permission = 'cms:login';
        $grant->role_id = 1;
        $grant->save();

        $grant = new PermissionGrant();
        $grant->permission = 'cms:user:manage';
        $grant->role_id = 1;
        $grant->save();

        $grant = new PermissionGrant();
        $grant->permission = 'cms:role:manage';
        $grant->role_id = 1;
        $grant->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
    }
}
