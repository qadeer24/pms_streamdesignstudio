<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\FrameWork;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class ProjectController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:projects-list', ['only' => ['index','show']]);
         $this->middleware('permission:projects-create', ['only' => ['create','store']]);
         $this->middleware('permission:projects-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:projects-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $project_price  = Project::whereMonth('created_at', Carbon::now()->month)->sum('project_price');
        $project_status = Project::whereMonth('created_at', Carbon::now()->month)->get();
        $projects       = Project::where('project_status',1)->count();
        $framework      = FrameWork::all();
        // $categories = Category::pluck('name','id')->all();
        $categories = Category::all();
        $users = User::where('id', '!=', 1)->get();
        $user_count = User::where('id', '!=', 1)->count();
        return view('projects.index',compact('categories','project_price', 'project_status','framework','users','user_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $new_name = "";
        if(isset($request['project_img'])){
            $image                  = $request->file('project_img');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                        $image->move(public_path("uploads/projects"),$new_name);
            $input['project_img']   = $new_name;
        }

        $request->assigned_to = json_encode($request->assigned_to);
        $project = Project::create([
            'name' => $request->name,
            'project_price' => $request->price,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'assigned_to' => $request->assigned_to,
            'project_category' => $request->project_category,
            'project_img' => $new_name,
            'tech_stack' => $request->tech_stack,
            'deadline' => $request->deadline,
            'db_name' => $request->db_name,
        ]);
        if ($project) {
            return response()->json(['success'=>$request->name. ' added successfully.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $latestCommentTimestamp = Comment::max('created_at');
        $project = Project::where('id',$id)->firstOrFail();
        $project->assigned_to = json_decode($project->assigned_to);
        $users = User::where('active', 1)
             ->where('id', '!=', 1)
             ->whereIn('id', $project->assigned_to)
             ->get();


        $categories  = Category::all();
        $comments  = Comment::where('project_id',$id)->get();

        $tasks = Task::selectRaw('
                    COUNT(*) as total_count,
                    SUM(task_status = 2) as overdue_count,
                    SUM(task_status = 0) as completed_count,
                    SUM(task_status = 1) as active_count
                ')
                ->where('project_id', $id)
                ->first();

        $framework = FrameWork::all();
        return view('projects.show',compact('project','users','categories','framework','tasks','comments','latestCommentTimestamp'));
    }

    public function search_user($keyword)
    {
        dd($keyword);
        $project = Project::where('id',$id)->firstOrFail();
        $users  = User::where('active',1)->where('id', '!=', 1)->get();
        return view('projects.show',compact('project','users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        $update_project = Project::where('id',$id)->firstOrFail();
        $update_project->name = $request->name;
        $update_project->project_price = $request->price;
        $update_project->description = $request->description;
        $update_project->project_category = $request->project_category;
        $update_project->tech_stack = $request->tech_stack;
        $update_project->db_name = $request->db_name;
        if (isset($request->deadline)) {
            $update_project->deadline = $request->deadline;
        }
        
        $new_name = "";
        if(isset($request['project_img'])){
            $image                  = $request->file('project_img');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                        $image->move(public_path("uploads/projects"),$new_name);
            $input['project_img']   = $new_name;
            $update_project->project_img = $new_name;
        }
        $update_project->save();
        return response()->json(['success'=>$request->name. ' updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }
}
