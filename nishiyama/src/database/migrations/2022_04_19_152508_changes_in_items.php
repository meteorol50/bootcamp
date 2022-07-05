<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesInItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_from_prefecture_id')->nullable()->after('internal_memo');
            $table->time('shipping_cutoff_time')->nullable()->after('shipping_rates')->change();
            $table->unsignedBigInteger('exhibitor_user_id')->after('shipping_number');
            $table->string('scheduled_delivery_date')->nullable()->after('shipping_cutoff_time');
            $table->string('guarantee_contents', 1024)->after('guarantee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['shipping_from_prefecture_id', 'exhibitor_user_id', 'scheduled_delivery_date', 'guarantee_contents']);
            $table->string('shipping_cutoff_time', 1024)->nullable()->after('shipping_rates')->change();
        });
    }
}
