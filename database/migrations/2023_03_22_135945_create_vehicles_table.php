<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{

    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('model', 30);
            $table->string('license_plate', 10);
            $table->string('color', 20);
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('brand_id');

            //add Fk between tables
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->foreign('brand_id')->references('id')->on('car_brands');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
