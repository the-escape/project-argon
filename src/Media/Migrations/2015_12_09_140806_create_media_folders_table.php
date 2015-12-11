<?php

use Escape\Argon\Media\Eloquent\MediaFolder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::create('media_folders', function (Blueprint $table) {
	    $table->increments('id');
	    $table->string('name');
	    $table->integer('parent')->nullable();
	    $table->timestamps();
	    $table->softDeletes();
	});

	$root = new MediaFolder();
	$root->name = "Library";
	$root->parent = null;
	$root->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	Schema::drop('media_folders');
    }
}
