<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iso_code', 2)->unique();
            $table->string('iso_code_3', 3);
            $table->unsignedInteger('iso_numeric');
            $table->string('fips_code', 2);
            $table->string('country_name');
            $table->string('country_capital');
            $table->string('continent_code', 2);
            $table->string('top_level_domain', 4);
            $table->string('currency_code', 3);
            $table->string('currency_name');
            $table->string('telephone_code');
            $table->string('postal_code_format');
            $table->string('postal_code_regex');
            $table->string('languages');
            $table->string('neighbours');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('countries');
    }
}
