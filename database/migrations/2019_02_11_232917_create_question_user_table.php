<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assignment_user_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('user_answer');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('book_questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('assignment_user_id')->references('id')->on('assignment_user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_answer')->references('id')->on('answer_responses')->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['assignment_user_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_user');
    }
}
