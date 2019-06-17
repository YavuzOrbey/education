<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Assignment;
use App\Subject;
use Carbon\Carbon;
class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('assignment_id');
            $table->unsignedInteger('subject_id');
            $table->timestamps();

            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');

            $table->index(['assignment_id', 'subject_id']);
        });

        $assignments = Assignment::all();
        $subjects = Subject::all();
        $sections = array();
            foreach ($assignments as $key => $assignment) {
                foreach ($subjects as $sKey => $subject) {
                    array_push($sections, ['assignment_id'=>$assignment->id, 'subject_id'=>$subject->id, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
                }
            }
                
            
            DB::table('sections')->insert($sections);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
