<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssignmentGroup;
use App\Assignment;
use App\Group;
class GroupAssignmentController extends Controller
{
    public function store(Request $request){
        //the request has to have the id of the group and the id of the assignment to make a relationship between them.

        $groupAssignment = new AssignmentGroup;
        
        $groupAssignment->due_date = date("Y-m-d H:i:s", strtotime($request->assignment['due_date']) +60*60*23 +60*59 + 59+4*60*60);
        
    }

    public function getAssignments(Group $group){
        $groupassignments = AssignmentGroup::where('group_id', $group->id)->get();
        $groupassignmentsOrdered = array();
        foreach ($groupassignments as $key => $groupAssignment) {
            $groupassignmentsOrdered[$key] = array();
            $groupassignmentsOrdered[$key]['id'] = $groupAssignment['id'];
            $groupassignmentsOrdered[$key]['assignment'] = array('id'=>$groupAssignment['assignment_id'], 'name'=>Assignment::find($groupAssignment['assignment_id'])->name );
            $groupassignmentsOrdered[$key]['due_date'] = $groupAssignment['due_date'];
        }

        return json_encode($groupassignmentsOrdered, JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $groupAssignmentNumber){
        // need to update the assignment_group row with new due_date 
        $groupAssignment = AssignmentGroup::find($groupAssignmentNumber);
        $groupAssignment->due_date = date("Y-m-d H:i:s", strtotime($request->groupAssignment[$groupAssignmentNumber]) +60*60*23 +60*59 + 59);
        $groupAssignment->save();
        $request->session()->flash('status', 'Task was successful!');
        return redirect()->route('assignments.manage');
    }
}
