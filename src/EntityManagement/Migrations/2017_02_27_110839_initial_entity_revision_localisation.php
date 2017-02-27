<?php

use Escape\Argon\EntityManagement\Eloquent\EntityRevision;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialEntityRevisionLocalisation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $localisation = new Localisation();
        $localisation->entity_id = 1;
        $localisation->locale_id = 1;
        $localisation->save();

        $revision = new EntityRevision();
        $revision->entity_localisation_id = $localisation->id;
        $revision->status = 2;
        $revision->created_by = 1;
        $revision->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Localisation::truncate();
        EntityRevision::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
