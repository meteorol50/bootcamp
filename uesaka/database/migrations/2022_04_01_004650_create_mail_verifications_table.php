<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailVerificationsTable extends Migration
{
    public function up()
    {
        Schema::create('mail_verifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mail_authentication');
            $table->string('mail')->unique();
            $table->timestamps();
        });
    }
// 略
}
