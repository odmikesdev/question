<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('card_id');
            $table->foreignId('user_id');
            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('cards');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->foreignId('card_id');
            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('cards');
        });
        Schema::create('notification_subscription', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id');
            $table->foreignId('subscription_id');
            $table->timestamps();

            $table->foreign('notification_id')->references('id')->on('notifications');
            $table->foreign('subscription_id')->references('id')->on('subscriptions');

        });
        
    }

    public function down()
    {
        Schema::table('notification_subscription', function (Blueprint $table) {
            $table->dropForeign('subscription_id');
            $table->dropForeign('notification_id');
            
        });
        Schema::dropIfExists('notification_subscription');

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('card_id');
        });
        Schema::dropIfExists('notifications');

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('card_id');
            $table->dropForeign('user_id');
        });   
        Schema::dropIfExists('subscriptions');
    }
};
