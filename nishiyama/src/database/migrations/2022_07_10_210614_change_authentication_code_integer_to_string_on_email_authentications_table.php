<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAuthenticationCodeIntegerToStringOnEmailAuthenticationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_authentications', function (Blueprint $table) {
            $table->string('authentication_code')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_authentications', function (Blueprint $table) {
            $table->integer('authentication_code')->change();
        });
    }
}
