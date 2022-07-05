<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesInParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->boolean('screen_display_item')->default(0)->change();
            $table->integer('disp_num')->default(999)->change();
            $table->boolean('status')->default(1)->change();
            $table->smallInteger('atrs_parts_code')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->tinyInteger('screen_display_item')->change();
            $table->integer('disp_num')->change();
            $table->tinyInteger('status')->change();
            $table->tinyInteger('atrs_parts_code')->default(0)->change();
        });
    }
}
