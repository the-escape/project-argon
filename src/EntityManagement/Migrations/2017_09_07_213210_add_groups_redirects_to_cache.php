<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupsRedirectsToCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_cache', function (Blueprint $table) {
            $table->longText('entity_groups')->nullable()->after('entity_url');
            $table->longText('entity_redirect')->nullable()->after('entity_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_cache', function(Blueprint $table) {
            $table->dropColumn('entity_groups');
            $table->dropColumn('entity_redirect');
        });
    }
}
