<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrameWork;
use App\Models\Category;
use App\Models\User;
use App\Models\Project;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Restriction to get client as user
        $users = User::whereHas(
                    'roles', function($q){
                        $q->where('name', '!=', 'client');
                    }
                )->where('id','!=',1)->get();
        
        $categories = Category::all();
        $framework = FrameWork::all();
        $project_price = Project::whereMonth('created_at', Carbon::now()->month)->sum('project_price');
        $projects = Project::where('project_status',1)->count();
        return view('home',compact('categories','framework','projects','project_price','users'));

    }
}
