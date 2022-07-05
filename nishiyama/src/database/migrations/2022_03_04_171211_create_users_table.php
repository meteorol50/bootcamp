<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table->tinyInteger('is_management')->default(0);
            $table->string('email')->unique();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('user_info_id')->nullable();
            $table->unsignedInteger('verification_code');
            $table->dateTime('expired_at');
            $table->dateTime('verified_at')->nullable();
            $table->string('crypted_password')->nullable();
            $table->string('salt')->nullable();
            $table->string('access_token')->nullable();
            $table->string('reset_password_token')->nullable();
            $table->dateTime('reset_password_expired_at')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->unsignedBigInteger('login_times')->nullable();
            $table->tinyInteger('withdraw_count')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            // 外部キー
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('user_info_id')->references('id')->on('user_info')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
