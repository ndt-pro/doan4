<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrGrAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');

        Schema::create('users', function ($table) {
            $table->id();
            $table->string('full_name', 50);
            $table->string('password');
            $table->char('phone_number', 10);
            $table->string('email', 100)->unique();
            $table->string('address')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
        // ===============================================================
        
        Schema::dropIfExists('admins');
        
        Schema::create('admins', function ($table) {
            $table->id();
            $table->string('username', 50);
            $table->string('password');
            $table->string('full_name', 50);
            $table->string('avatar');
            $table->rememberToken();
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
        //
    }
}
