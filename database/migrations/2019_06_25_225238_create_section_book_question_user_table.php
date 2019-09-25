<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionQuestionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_book_question_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_book_question_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('section_book_question_id')->references('id')->on('section_book_questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_question_user');
    }
}
