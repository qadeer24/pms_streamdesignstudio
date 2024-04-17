<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Auth;

class TaskController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:tasks-list', ['only' => ['index','show']]);
         $this->middleware('permission:tasks-create', ['only' => ['create','store']]);
         $this->middleware('permission:tasks-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:tasks-delete', ['only' => ['destroy']]);
    }

    public function index($id)
    {
        $project = Project::where('id',$id)->firstOrFail();
        $tasks = Task::where('project_id',$id)->get();
        foreach ($tasks as $key => $value) {
            $value->assigned_to = json_decode($value->assigned_to);
        }
        $users = User::where('active', 1)
             ->where('id', '!=', 1)
             ->get();
        return view('tasks.index',compact('tasks','users','project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $new_name = "";
        if(isset($request['task_img'])){
            $image                  = $request->file('task_img');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                        $image->move(public_path("uploads/projects"),$new_name);
            $input['task_img']   = $new_name;
        }

        $task = Task::create([
            'name'          => $request->name,
            'deadline'      => $request->deadline,
            'description'   => $request->description,
            'assigned_to'   => json_encode($request->assigned_to),
            'task_img'      => $new_name,
            'project_id'    => $request->project_id,
            'created_by'    => Auth::user()->id,
        ]);

        if ($task) {
            return response()->json(['success'=>$request->name. ' added successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task = Task::where('id', $request->task_id)->first();

        $new_name = "";
        if(isset($request['task_img'])){
            $image                  = $request->file('task_img');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                        $image->move(public_path("uploads/projects"),$new_name);
            $input['task_img']      = $new_name;
        }

        $task->name         = $request->name;
        $task->description  = $request->description;
        if (isset($request->assigned_to)) {
            $task->assigned_to  = json_encode($request->assigned_to);
        }
        $task->deadline         = $request->deadline;
        $task->save();
        if ($task) {
            return response()->json(['success'=>$request->name. ' updated successfully.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully');
    }
}
