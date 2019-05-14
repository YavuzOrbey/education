<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->char('letter', 1);
        });

        DB::table('answer_responses')->insert([
            ['letter'=>'A'],
            ['letter' => 'B'],
            ['letter' => 'C'],
            ['letter' => 'D']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_responses');
    }
}
