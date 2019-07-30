<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupsAndRedirectsToRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_revisions', function(Blueprint $table)
        {
            $table->text('entity_redirects')->nullable()->after('status');
            $table->text('entity_groups')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_revisions', function(Blueprint $table)
        {
            $table->dropColumn('entity_redirects');
            $table->dropColumn('entity_groups');
        });
    }
}
