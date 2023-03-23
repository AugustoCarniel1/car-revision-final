<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 100);
            $table->bigInteger('cpf');
            $table->string('email', 100);
            $table->bigInteger('phone');
            $table->string('gender', 5);
            $table->date('birth_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('owners');
    }
}
