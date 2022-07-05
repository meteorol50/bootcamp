<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDaihatsuCompatibleParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daihatsu_compatible_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('symbol_id');
            $table->string('drive_system')->nullable();
            $table->unsignedBigInteger('mission_id')->nullable();
            $table->unsignedBigInteger('engine_id')->nullable();
            $table->string('parts_no');
            $table->boolean('status');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daihatsu_compatible_parts');
    }
}
