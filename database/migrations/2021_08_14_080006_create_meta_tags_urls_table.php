<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaTagsUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_tags_urls', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->text('url')->nullable();
			$table->text('title')->nullable();
			$table->text('description')->nullable();
			$table->text('keywords')->nullable();
			$table->boolean('active')->unsigned()->nullable()->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meta_tags_urls');
    }
}
