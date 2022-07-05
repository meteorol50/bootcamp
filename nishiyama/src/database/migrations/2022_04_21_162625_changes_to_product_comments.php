<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesToProductComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->boolean('exhibitor_flg')->comment('0：出品者以外、1：出品者')->after('comment');
            $table->unsignedBigInteger('user_id')->after('exhibitor_flg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_comments', function (Blueprint $table) {
            $table->dropColumn(['exhibitor_flg', 'user_id']);
        });
    }
}
