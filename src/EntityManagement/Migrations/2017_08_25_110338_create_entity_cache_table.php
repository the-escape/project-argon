<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_cache', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entity_id')->unsigned();
            $table->integer('entity_localisation_id')->unsigned();
            $table->integer('entity_locale_id')->unsigned();
            $table->integer('entity_type_id')->unsigned();
            $table->integer('entity_parent_id')->unsigned()->nullable();
            $table->smallInteger('entity_status');
            $table->string('entity_name');
            $table->string('entity_slug');
            $table->string('entity_url')->nullable();
            $table->timestamp('entity_updated_at')->nullable();
            $table->longText('cache');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['entity_id']);
            $table->index(['entity_url']);
            $table->index(['entity_id', 'entity_localisation_id']);
            $table->index(['entity_type_id']);
            $table->index(['entity_parent_id']);
            $table->index(['entity_slug']);
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entity_cache');
    }
}
