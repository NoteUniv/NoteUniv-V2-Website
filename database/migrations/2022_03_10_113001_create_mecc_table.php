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
        Schema::create('mecc', function (Blueprint $table) {
            $table->id();
            $table->integer('ue');
            $table->integer('semester');
            $table->string('subject_code')->nullable();
            $table->string('subject_name');
            $table->integer('coefficient');
            $table->string('promo');
            $table->year('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mecc');
    }
};
