<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentstatusToUserWalletmoneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_walletmoneys', function (Blueprint $table) {
            $table->string('transaction_id')->nullable(false)->default(null)->after('receipt');
            $table->tinyInteger('payment_status')->nullable(false)->default(0)->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_walletmoneys', function (Blueprint $table) {
            //
        });
    }
}
