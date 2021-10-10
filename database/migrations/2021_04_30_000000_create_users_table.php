<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('name', '100');
            $table->string('email', '100')->unique();
            $table->string('mobile_no')->unique()->nullable();
            $table->string('avatar')->unique()->nullable();
            $table->enum('gender', ['1', '2'])->comment = "1=male,2=female";
            $table->enum('status', ['0', '1'])->default('1')->comment = "0=>deactive,1=active";
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('created_by', '50')->nullable();
            $table->string('modified_by', '50')->nullable();
            $table->timestamps();
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
