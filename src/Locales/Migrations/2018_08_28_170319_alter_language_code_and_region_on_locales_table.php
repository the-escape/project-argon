<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLanguageCodeAndRegionOnLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locales', function (Blueprint $table)
        {
            $table->dropColumn('region');
            $table->dropColumn('languageCode');
            $table->string('language_id', 3)->after('name');
            $table->string('country_id')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locales', function(Blueprint $table)
        {
            $table->string('region')->after('name');
            $table->string('languageCode')->after('name');
            $table->dropColumn('language_id');
            $table->dropColumn('country_id');
        });
    }
}
