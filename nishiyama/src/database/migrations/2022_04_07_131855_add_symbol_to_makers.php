<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSymbolToMakers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('makers', function (Blueprint $table) {
            $table->string('atrs_maker_symbol', 2)->after('maker_logo_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('makers', function (Blueprint $table) {
            $table->dropColumn('atrs_maker_symbol');
        });
    }
}
