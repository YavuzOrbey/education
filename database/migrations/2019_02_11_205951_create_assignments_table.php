<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        $tests = array();
        for ($i=1; $i < 5; $i++) { 
            array_push($tests, ['name'=>'SAT Practice Test ' . $i ,'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        }
        DB::table('assignments')->insert($tests);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
