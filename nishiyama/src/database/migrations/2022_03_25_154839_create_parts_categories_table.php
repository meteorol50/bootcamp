<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts_categories', function (Blueprint $table) {
            $table->id();
			$table->tinyInteger('status');
			$table->string('name')->unique();
			$table->tinyInteger('core_return_flag');
			$table->integer('disp_num');
			$table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
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
        Schema::dropIfExists('parts_categories');
    }
}
