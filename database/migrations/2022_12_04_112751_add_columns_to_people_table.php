<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('join_desc')->after('is_force');
            $table->timestamp('join_date')->nullable()->default(null);
            $table->string('deleted_desc');
            $table->timestamp('deleted_date')->nullable()->default(null);
            $table->unsignedSmallInteger('medical_state')->default(1);
            $table->string('medical_cause')->nullable();
            $table->timestamp('lay_off_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn(['join_desc', 'join_date', 'deleted_desc', 'deleted_date', 'medical_state', 'medical_cause', 'lay_off_date']);
        });
    }
}
