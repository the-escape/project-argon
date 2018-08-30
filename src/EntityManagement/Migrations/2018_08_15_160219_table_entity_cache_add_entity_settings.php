<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableEntityCacheAddEntitySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_cache', function (Blueprint $table) {
            $table->longText('entity_settings')->after('entity_redirect');
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
            $table->dropColumn('entity_settings');
        });
    }
}
