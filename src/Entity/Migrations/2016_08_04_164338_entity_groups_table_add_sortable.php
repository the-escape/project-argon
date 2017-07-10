<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntityGroupsTableAddSortable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_groups', function (Blueprint $table) {
            $table->enum('sortable', ['0', '1'])->after('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_groups', function (Blueprint $table) {
            $table->dropColumn('sortable');
        });
    }
}
