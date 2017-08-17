<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnailToEntityGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_groups', function (Blueprint $table) {
            $table->int('thumbnail')->after('sortable');
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
            $table->dropColumn('thumbnail');
        });
    }
}
