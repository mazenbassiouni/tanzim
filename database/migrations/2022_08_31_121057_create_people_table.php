<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('military_num');
            $table->unsignedInteger('seniority_num')->nullable();
            $table->unsignedTinyInteger('rank_id');
            $table->string('name');
            $table->unsignedInteger('speciality_id');
            $table->unsignedInteger('mil_unit_id');
            $table->unsignedInteger('unit_id');
            $table->boolean('is_force')->default(1);
            $table->boolean('service')->default(1);
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
        Schema::dropIfExists('people');
    }
}
