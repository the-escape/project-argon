<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entity_type_id')->unsigned();
            $table->integer('entity_group_id')->unsigned();
            $table->string('name');
            $table->string('field_type');
            $table->text('settings');
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
        Schema::drop('entity_fields');
    }
}
