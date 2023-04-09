<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields', function (Blueprint $table) {
			$table->increments('id');
			$table->enum('belongs_to', ['posts', 'users']);
			$table->text('name')->nullable();
			$table->string('type', 50)->default('text');
			$table->integer('max')->unsigned()->nullable()->default('255');
			$table->text('default_value')->nullable();
			$table->boolean('required')->unsigned()->nullable();
			$table->boolean('use_as_filter')->nullable()->default('0');
			$table->text('help')->nullable();
			$table->boolean('active')->unsigned()->nullable();
			$table->index(["belongs_to"]);
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fields');
	}
}
