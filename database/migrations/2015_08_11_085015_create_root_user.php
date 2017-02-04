<?php

use Escape\Argon\Auth\User;
use Illuminate\Database\Migrations\Migration;

class CreateRootUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = new User;
        $user->name = 'Root';
        $user->email = 'root@the-escape.co.uk';
        $user->password = 'e5cape';
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where('email', 'root@the-escape.co.uk')->first()->delete();
    }
}
