<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_info', function (Blueprint $table) {
            $table->id();
            $table->string('confirm_request_contents')->nullable();
            $table->unsignedBigInteger('parts_id');
            $table->string('vehicle_no')->nullable();            
            $table->string('car_model_designation_no')->nullable();
            $table->string('classification_classification_no')->nullable();
            $table->string('car_models_name')->nullable();
            $table->string('model_year_month')->nullable();
            $table->string('request_for_parts')->nullable();
            $table->string('request_memo')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('request_info');
    }
}
