<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assignment_user_id');
            $table->unsignedInteger('book_question_id');
            $table->unsignedInteger('user_answer');
            $table->timestamps();

            $table->foreign('book_question_id')->references('id')->on('book_questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('assignment_user_id')->references('id')->on('assignment_user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_answer')->references('id')->on('answer_responses')->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['assignment_user_id', 'book_question_id']);
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
