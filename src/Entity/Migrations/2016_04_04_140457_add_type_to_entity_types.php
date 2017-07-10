<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToEntityTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_types', function (Blueprint $table) {
            $table->enum('type', ['page', 'block', 'email'])->after('system');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_types', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
