<?php

use Escape\Argon\EntityManagement\Eloquent\EntityRevision;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
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
        $localisations = Localisation::all();
        foreach ($localisations as $localisation) {
            $revision = new EntityRevision();
            $revision->entity_localisation_id = $localisation->id;
            $revision->status = 2;
            $revision->created_by = 1;
            $revision->save();
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        EntityRevision::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
