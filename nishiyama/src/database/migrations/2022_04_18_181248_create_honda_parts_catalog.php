<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHondaPartsCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honda_parts_catalog', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grade_id');
            $table->string('model_code');
            $table->string('parts_catalog_type');
            $table->boolean('comfort_hackage')->default(0);
            $table->boolean('hower_utility_package')->default(0);
            $table->boolean('3rd_row_electric_underfloor_retractable_seat')->default(0);
            $table->boolean('sight_curtain_airbags')->default(0);
            $table->boolean('navigation_system')->default(0);
            $table->boolean('sunroof')->default(0);
            $table->boolean('hower_tailgate')->default(0);
            $table->boolean('res')->default(0);
            $table->boolean('cd')->default(0);
            $table->boolean('premium_sound_system')->default(0);
            $table->boolean('ihcc')->default(0);
            $table->boolean('vsa')->default(0);
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
        Schema::dropIfExists('honda_parts_catalog');
    }
}
