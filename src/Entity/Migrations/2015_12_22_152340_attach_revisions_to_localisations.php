<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttachRevisionsToLocalisations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_revisions', function (Blueprint $table) {
            $table->renameColumn('entity_id', 'entity_localisation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_revisions', function (Blueprint $table) {
            $table->renameColumn('entity_localisation_id', 'entity_id');
        });
    }
}
