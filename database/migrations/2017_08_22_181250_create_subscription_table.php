<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('heading_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('heading_id')->references('id')->on('headings');
            $table->timestamps();

            $table->unique(['user_id', 'heading_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
