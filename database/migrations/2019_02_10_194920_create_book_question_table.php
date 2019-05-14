<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_number');
            $table->unsignedInteger('correct_answer');
            $table->timestamps();

            $table->foreign('correct_answer')->references('id')->on('answer_responses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_question');
    }
}
