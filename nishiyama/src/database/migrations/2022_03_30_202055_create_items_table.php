<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_title')->nullable();
            $table->unsignedBigInteger('cars_info_id')->nullable();
            $table->unsignedBigInteger('parts_id');
            $table->string('parts_no');
            $table->boolean('parts_classification')->nullable();
            $table->boolean('stock_status')->nullable();
            $table->boolean('quality_rank')->nullable();
            $table->string('parts_infomation', 1024)->nullable();
            $table->string('injury_information', 1024)->nullable();
            $table->string('remark_1', 1024)->nullable();
            $table->string('remark_2', 1024)->nullable();
            $table->boolean('core_flat_magpie')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('guarantee_flag')->nullable();
            $table->string('guarantee')->nullable();
            $table->integer('sales_price');
            $table->integer('sales_commission')->nullable();
            $table->integer('sales_profit')->nullable();
            $table->integer('parts_cost')->nullable();
            $table->integer('new_item_price')->nullable();
            $table->integer('retail_unit_price')->nullable();
            $table->string('internal_memo', 1024)->nullable();
            $table->string('select_shipping_company')->nullable();
            $table->integer('shipping_rates')->nullable();
            $table->string('shipping_cutoff_time', 1024)->nullable();
            $table->bigInteger('atrs_parts_control_number');
            $table->date('registration_date')->nullable();
            $table->string('parts_manufacturer_name')->nullable();
            $table->string('parts_manufacturer_parts_no')->nullable();
            $table->string('stock_merchants')->nullable();
            $table->string('shipping_number')->nullable();
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
        Schema::dropIfExists('items');
    }
}
