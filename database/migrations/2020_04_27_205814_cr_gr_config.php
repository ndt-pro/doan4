<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrGrConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cf_slideshow', function ($table) {
            $table->id();
            $table->string('image');
            $table->string('url');
            $table->tinyInteger('index')->default(0);
            $table->boolean('show')->default(1);
        });
        
        // ===============================================================

        Schema::create('cf_brands', function ($table) {
            $table->id();
            $table->string('image');
            $table->boolean('show')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cf_slideshow');
        Schema::dropIfExists('cf_brands');
    }
}
