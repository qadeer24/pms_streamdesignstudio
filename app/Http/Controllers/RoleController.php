<?php
namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:role-list', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $permissions     = Permission::get();
        $roles = DB::table('roles')
            ->leftJoin('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->leftJoin('role_has_permissions', 'roles.id', '=', 'role_has_permissions.role_id')
            ->select('roles.id', 'roles.name', DB::raw('count(distinct model_has_roles.model_id) as user_count'))
            ->selectRaw('GROUP_CONCAT(role_has_permissions.permission_id) as permission_ids')
            ->groupBy('roles.id', 'roles.name')
            ->get();

        return view('roles.index',compact('permissions','roles'));
    }

    public function list()
    {
        $user_id        = Auth::user()->id;

   
        if($user_id == 1){
            $data       = Role::get();
        }else{
            $data       = Role::where('id','!=',1)->get();
        }

        return DataTables::of($data)
                ->addColumn('action',function($data){
                return 
                        '<div class="btn-group btn-group">
                            <a class="btn btn-info btn-xs" href="roles/'.$data->id.'/edit" id="'.$data->id.'">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function create()
    {
        $permission     = Permission::get();
        return view('roles.create',compact('permission'));
    }


    public function store(RoleRequest $request)
    {
        // Retrieve the validated input data...
        $validated      = $request->validated();

        $role           = Role::create(['name' => $request->input('name')]);
                          $role->syncPermissions($request->input('permission'));

        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }

    public function show($id)
    {
        $role               = Role::findorFail($id);
        $rolePermissions    = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                                ->where("role_has_permissions.role_id",$id)
                                ->get();

        return view('roles.show',compact('role','rolePermissions'));
    }


    public function edit($id)
    {
        $data               = Role::findorFail($id);
        $permission         = Permission::get();
        $rolePermissions    = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                ->all();

        return view('roles.edit',compact('data','permission','rolePermissions'));
    }


    public function update(RoleRequest $request)
    {
        if($request->role_id == 1){
            return response()->json(['error'=> 'This is Super-Admin role and cannot be updated']);
        }

        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $role        = Role::findOrFail($request->role_id);
        $role->name  = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        return response()->json(['success'=>$request['name']. ' updated successfully.']);
    }
    
    public function destroy($id)
    {
        if($id == 1){
            return response()->json(['error'=> 'This is Super-Admin role and cannot be deleted']);
        }

        if($id==1){
            return response()->json(['error'=> 'This is logged in user role, cannot be deleted']);
        }else{
            $data = Role::where('id',$id)->delete();
            return redirect()->route('roles.index')->with('success_message', 'Role deleted successfully');
        }
    }
}
