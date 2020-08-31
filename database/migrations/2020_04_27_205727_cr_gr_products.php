<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrGrProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_type', function ($table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('logo');
            $table->timestamps();
        });

        // ===============================================================

        Schema::create('products', function ($table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('products_type')->onDelete("cascade");
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->json('colors')->default('[]');
            $table->json('sizes')->default('[]');
            $table->timestamps();
        });
        
        // ===============================================================

        Schema::create('product_image', function ($table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete("cascade");
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_image');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_type');
    }
}
