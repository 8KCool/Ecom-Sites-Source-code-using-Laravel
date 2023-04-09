<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletmoneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_walletmoneys', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->bigInteger('user_id');
            $table->string('payment_method', 100);
            $table->double('amount', 10, 2);
            $table->text('receipt');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_walletmoneys');
    }
}
