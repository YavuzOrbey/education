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
            $table->unsignedInteger('id')->unique();
            $table->char('letter', 1);
        });

        DB::table('answer_responses')->insert([
            ['id'=>0, 'letter'=>''],
            ['id'=>1, 'letter'=>'A'],
            ['id'=>2, 'letter' => 'B'],
            ['id'=>3, 'letter' => 'C'],
            ['id'=>4, 'letter' => 'D']
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
