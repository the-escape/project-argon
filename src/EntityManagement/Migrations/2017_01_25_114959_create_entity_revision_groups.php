<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityRevisionGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_revision_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entity_revision_id')->unsigned();
            $table->integer('entity_group_id')->unsigned();
            $table->integer('status')->unsigned();
            $table->integer('order')->unsigned();
            $table->timestamps();
            $table->timestamp('deleted_at');

            $table->foreign('entity_revision_id')->references('id')->on('entity_revisions')->onDelete('cascade');
            $table->foreign('entity_group_id')->references('id')->on('entity_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entity_revision_groups');
    }
}
