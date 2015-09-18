<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Escape\Argon\Locales\Eloquent\Locale;

class CreateLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('languageCode');
            $table->string('region');
            $table->timestamps();
            $table->softDeletes();
        });

        $locale = new Locale();
        $locale->name = 'Global';
        $locale->languageCode = 'en_GB';
        $locale->region = 'Global';
        $locale->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locales');
    }
}
