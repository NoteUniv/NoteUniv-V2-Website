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
        Schema::create('users_grades', function (Blueprint $table) {
            $table->foreignId('student_id');
            $table->foreignId('grade_id')->references('id')->on('grades')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->float('grade_value');

            $table->primary(['student_id', 'grade_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_grades');
    }
};
