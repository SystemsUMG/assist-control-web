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
        Schema::create('student_attendance_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attendance_data_id')->nullable(false);
            $table->unsignedBigInteger('student_course_assigned_id')->nullable(false);
            $table->dateTime('schedule_register')->nullable(false);
            $table->foreign('attendance_data_id')->references('id')->on('attendance_data');
            $table->foreign('student_course_assigned_id')->references('id')->on('student_course_assigneds');
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
        Schema::dropIfExists('student_attendance_data');
    }
};
