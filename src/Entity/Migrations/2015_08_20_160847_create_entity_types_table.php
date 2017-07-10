<?php

use Escape\Argon\Entity\Eloquent\EntityType;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('system');
            $table->timestamps();
            $table->softDeletes();
        });

        $site = new EntityType();
        $site->name = 'site';
        $site->system = true;
        $site->save();

        $page = new EntityType();
        $page->name = 'page';
        $page->system = false;
        $page->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entity_types');
    }
}
