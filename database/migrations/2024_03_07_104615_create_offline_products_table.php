<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->string('price');
            $table->string('stock');
            $table->string('image');
            $table->string('description');
            $table->unsignedBigInteger('business_unit_id');
            $table->foreign('business_unit_id')->references('id')->on('business_units');
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
        Schema::dropIfExists('offline_products');
    }
};
