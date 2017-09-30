<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubtypeToEntityCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_cache', function (Blueprint $table) {
            $table->string('entity_type_type')->after('entity_type_id');
            $table->index('entity_type_type', 'idx_entity_type_type');
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
            $table->dropIndex('idx_entity_type_type');
            $table->dropColumn('entity_type_type');
        });
    }
}
