<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCarsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars_info', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->unsignedBigInteger('car_model_id');
            $table->string('abbreviated_model')->nullable();
            $table->string('car_model_designation_no', 5);
            $table->unsignedBigInteger('grade_id');
            $table->string('classification_no', 4);
            $table->string('full_model_car_model')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('model_year', 4)->nullable();
            $table->string('model_month', 2)->nullable();
            $table->unsignedBigInteger('mission_id')->nullable();
            $table->string('transmission_model')->nullable();
            $table->string('trans_no')->nullable();
            $table->boolean('drive_method')->nullable();
            $table->string('axle_no')->nullable();
            $table->unsignedBigInteger('engine_id')->nullable();
            $table->smallInteger('engine_displacement')->nullable();
            $table->boolean('engine_classification')->nullable();
            $table->string('engine_no')->nullable();
            $table->integer('mileage')->nullable();
            $table->unsignedBigInteger('exterior_color_id')->nullable();
            $table->unsignedBigInteger('interior_color_id')->nullable();
            $table->string('tire')->nullable();
            $table->smallInteger('displacement')->nullable();
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
        Schema::dropIfExists('cars_info');
    }
}
