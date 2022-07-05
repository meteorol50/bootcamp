<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateToyotaFeatureSymbol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toyota_feature_symbol', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grade_id');
            $table->string('full_model_car_model');
            for ($i = 1; $i < 22; $i++) {
                $table->string("feature_symbol_{$i}")->nullable();
            }
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
        Schema::dropIfExists('toyota_feature_symbol');
    }
}
