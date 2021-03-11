<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('rating');
            $table->string('email');
            $table->string('telephone');
            $table->string('website');
            $table->string('address');
            $table->integer('photo');
            $table->integer('reviews');
            $table->string('select');
            $table->boolean('score')->default(false);
            $table->string('status')->default('unclaimed');
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
        Schema::dropIfExists('leads');
    }
}
