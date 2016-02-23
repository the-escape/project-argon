<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameParentColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->renameColumn('parent', 'parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->renameColumn('parent_id', 'parent');
        });
    }
}
