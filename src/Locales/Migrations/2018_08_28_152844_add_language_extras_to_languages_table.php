<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguageExtrasToLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table)
        {
            $table->string('language_flow', 3)->after('language_name');
            $table->string('language_native_name')->after('language_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages', function(Blueprint $table)
        {
            $table->dropColumn('language_flow');
            $table->dropColumn('language_native_name');
        });
    }
}
