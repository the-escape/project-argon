<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::create('media_items', function (Blueprint $table) {
	    $table->increments('id');
	    $table->string('filename');
	    $table->string('extension');
	    $table->integer('folder');
	    $table->integer('filesize');
	    $table->string('mimetype');
	    $table->text('meta');
	    $table->integer('uploaded_by');
	    $table->timestamps();
	    $table->softDeletes();
	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	Schema::drop('media_items');
    }
}
