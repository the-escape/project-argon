<?php

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $entity = new Entity;
        $entity->name = 'Home';
        $entity->slug = '/';
        $entity->entity_type_id = 1;
        $entity->owner_id = 1;
        $entity->status = 1;
        $entity->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Entity::where('name', 'Site')->first()->delete();
    }
}
