<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsoptionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields_options', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('field_id')->unsigned()->nullable();
			$table->mediumtext('value')->nullable();
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('lft')->unsigned()->nullable();
			$table->integer('rgt')->unsigned()->nullable();
			$table->integer('depth')->unsigned()->nullable();
			$table->index(["field_id"]);
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fields_options');
	}
}
