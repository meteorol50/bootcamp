<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('postal_code');
            $table->unsignedBigInteger('prefecture_id');
            $table->string('city');
            $table->string('address');
            $table->string('building')->nullable();
            $table->string('tel');
            $table->string('fax')->nullable();
            $table->text('other')->nullable();
            $table->unsignedBigInteger('shipping_id');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
