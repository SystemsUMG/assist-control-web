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
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('email')->nullable(false)->unique();
            $table->string('password')->nullable(false);
            $table->date('begin_date')->nullable(false);
            $table->date('end_date')->nullable(false);
            $table->integer('age')->nullable(false);
            $table->string('dpi')->nullable(false);
            $table->string('carnet')->nullable(false);
            $table->unsignedBigInteger('career_assigned_id')->nullable(false);
            $table->foreign('career_assigned_id')->references('id')->on('career_assigneds');
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
        Schema::dropIfExists('students');
    }
};
