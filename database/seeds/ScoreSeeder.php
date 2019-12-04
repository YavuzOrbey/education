<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::pluck('id')->toArray();
        $assignments = App\Assignment::pluck('id')->toArray();

        $scores = array();
        $usedScores = array();
        //somewhere in here I have to check whether that same user id and assignment id have been used
        $i=0;
        while($i<10){
            $userId = $users[rand(0,count($users)-1)];
            $assignmentId = $assignments[rand(0,count($assignments)-1)];

            if(!in_array($usedScores, [$userId, $assignmentId])){
                array_push($scores, 
                ['user_id'=>$userId , 
                'assignment_id'=>$assignmentId,
                'score'=>rand(0,100),
                'created_at'=>Carbon::now(), 
                'updated_at'=>Carbon::now()]);
                array_push($usedScores, [$userId, $assignmentId]);
                $i++;
            }
        }

        DB::table('assignment_user')->insert($scores);
    }
}
