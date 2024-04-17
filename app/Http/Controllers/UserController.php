<?php
namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use Illuminate\Support\Facades\Session;
use DataTables;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Mail;
use Exception;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit|user-profileEdit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
         // $this->middleware('permission:user-profileEdit', ['only' => ['profileedit','update']]);
    }

    public function index(Request $request)
    {
        $permission     = Permission::get();
        $roles          = Role::where('id','!=',1)->pluck('name','name')->all();
        $member_roles   = Role::where('id','!=',1)->where('name','!=','Client')->pluck('name','name')->all();
        if (Auth::user()->roles[0]->id == 1) {
            $users = User::all();
        }else{
            $users = User::where('id',Auth::user()->id)->get();
        }
        return view('users.index',compact('users','permission','roles','member_roles'));
    }

    public function create()
    {
        $roles  = Role::where('id','!=',1)->pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // get all request
        $input       = $request->all();

        // uploading image
        if(isset($request['profile_pic'])){
            $image                  = $request->file('profile_pic');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                        $image->move(public_path("uploads/users"),$new_name);
            $input['profile_pic']   = $new_name;
        }

        // creating encrypted password
        $input['password']          = Hash::make($input['password']);

        // store new entity
        $data                       = User::create($input);

        // assign role 
        $data->assignRole($request->input('roles'));

        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }

    // public function storeMember(UserRequest $request)
    // {
    //     try {
    //         // Retrieve the validated input data...
    //         $validated = $request->validated();

    //         // get all request
    //         $input = $request->all();

    //         // uploading image
    //         $new_name = "";
    //         if(isset($request['member_img'])){
    //             $image = $request->file('member_img');
    //             $new_name = rand().'.'.$image->getClientOriginalExtension();
    //             $image->move(public_path("uploads/users"),$new_name);
    //             $input['member_img'] = $new_name;
    //         }

    //         // creating encrypted password
    //         $input['password'] = Hash::make($input['password']);

    //         // Find role
    //         $roleFind = Role::where('name',$input['role'])->firstOrFail();

    //         $input['role'] = $roleFind->id;

    //         // store new entity
    //         $data = User::create($input);

    //         // update user profile picture
    //         $data_user = User::where('id',$data->id)->first();
    //         $data_user->profile_pic = $new_name;
    //         $data_user->save();

    //         // create team member
    //         $data_member = TeamMember::create($input);

    //         // assign role 
    //         $data->assignRole($request->input('role'));

    //         return response()->json(['success'=>$request['name']. ' added successfully.']);
    //     } catch (\Exception $e) {
    //         // Handle any exceptions here
    //         return response()->json(['error' => 'An error occurred while processing your request.'], 500);
    //     }
    // }

    public function reset_pass_view()
    {
        return view('auth.reset');
    }

    public function confirm_pin()
    {
        return view('auth.confirm_pin');
    }

    public function new_pass()
    {
        return view('auth.new_pass');
    }

    public function detail_new_pass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->route('new_pass')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email',$request->email)->first();
        if (!$user) {
            return redirect()->route('new_pass')->with(['error_message'=>"No user with this email could be found"], 500);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with(['success_message'=>"Your password has been reset, please login to confirm your account"]);
    }

    public function confirm_code(Request $request)
    {
        $check_user = User::where('pin_code',$request->pin_code)->where('email',$request->email)->first();
        if (!$check_user) {
            return redirect()->route('confirm_pin')->with(['error_message'=>" Incorrect pin, the pic code does not match"], 500);
        }
        $check_user->pin_code = null;
        $check_user->save();
        return redirect()->route('new_pass');
    }

    public function reset_pass(Request $request)
    {
        $pin_code = rand(11111,99999);
        $to_email = $request->email;

        $check_user = User::where('email',$request->email)->first();
        if (!$check_user) {
            return redirect()->route('reset_pass')->with(['error_message'=>"No user with this email could be found ".$to_email], 500);
        }

        try {
            if (!filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("$to_email is not a valid email");
            }

            $check_user->pin_code = $pin_code;
            $check_user->save();

            $check_mail = Mail::send('mails.reset', ['email' => $to_email, 'pin_code' => $pin_code], function ($message) use ($to_email) {
                $message->from("contact@streamdesignstudio.com", 'PMS Stream Design Studio');
                $message->to($to_email, "test-name")->subject('Password reset request for PMS - Stream Design Studio');
            });
        } catch (Exception $e) {
            // Log the exception
            \Log::error('Email sending failed: ' . $e->getMessage());

            // Return a JSON response with error message
            return redirect()->route('reset_pass')->with(['error_message'=>"Failed to send email ".$to_email], 500);
        }
        Session::put('confirmation_email', $to_email);
        return redirect()->route('confirm_pin')->with(['success_message'=>"Your 5 digits code successfully sent to you email ".$to_email]);
    }

    public function invite_member(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $to_email = $request->email;
            $short_message = $request->short_message;
            $role = $request->role;

            $user = User::create(
                [
                    'email' => $to_email,
                    'invited_by' => Auth::id(),
                    'active' => 0,
                ]
            );

            $user_id = $user->id;

            Mail::send('mails.index', compact('short_message', 'to_email', 'role', 'user_id'), function ($message) use ($to_email) {
                $message->from("contact@streamdesignstudio.com", 'PMS Stream Design Studio');
                $message->to($to_email)->subject('Invitation to register at PMS - Stream Design Studio');
            });

            return response()->json(['success' => 'Email sent to ' . $to_email]);
        } catch (Exception $e) {
            // Log the exception
            \Log::error('Email sending failed: ' . $e->getMessage());

            // Return a JSON response with error message
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }

    public function show_invited_details($email, $id, $role)
    {
        $data = User::where('id', $id)->orWhere('email', $email)->firstOrFail();
        Session::put('user_register_email', $email);
        Session::put('user_register_role', $role);
        Session::put('user_register_id', $id);
        return redirect()->route('register');
    }


    public function mailshow(){
        return view('mails.index');
    }

    public function show($id)
    {
        $data           = DB::table('users')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('users.*','roles.name as rn')
                            ->where('users.id', $id)
                            ->first();
      
        return view('users.show',compact('data'));
    }

    public function show_user($id)
    {
        $user = User::where('id',$id)->firstOrFail();
        $roles = Role::where('id','!=',1)->pluck('name','id')->all();
        $member_roles   = Role::where('id','!=',1)->where('name','!=','Client')->pluck('name','name')->all();
        // Check if the user is not a client and if they exist in the team_members table
        $teamMemberExists = DB::table('team_members')->where('name', $user->name)->exists();

        // Check if the user is not a client
        if (($user->roles[0]->id != 1) && (strtolower($user->roles[0]->name) != 'client' && $teamMemberExists)) {
            // Join the users table with the team_members table
            $user = $user->join('team_members', 'users.name', '=', 'team_members.name')
                        ->where('users.name', '=', $user->name)
                        ->select(
                             'users.id', 
                             'users.name', 
                             'users.email', 
                             'users.email_verified_at', 
                             'users.password', 
                             'users.contact_no', 
                             'users.description', 
                             'users.session_status', 
                             'users.invited_by', 
                             'users.profile_pic', 
                             'users.active', 
                             'users.remember_token', 
                             'users.created_by', 
                             'users.updated_by', 
                             'users.deleted_at', 
                             'users.created_at', 
                             'users.updated_at',
                             'team_members.role',
                             'team_members.member_img',
                             'team_members.joined_at',
                             'team_members.responsibility_level',
                             'team_members.position',
                             'team_members.salary'
                         )
                         ->firstOrFail();
        }

        return view('users.show', compact('user', 'roles', 'member_roles'));
    }



    public function profileedit($id)
    {
        $user           = User::find($id);
        $roles          = Role::pluck('name','name')->all();
        $userRole       = $user->roles->pluck('name','name')->all();
        $designations   = Designation::pluck('name','id')->all();

        return view('profile.edit',compact('user','roles','userRole','designations'));
    }

    public function profileShow($id)
    {
        $user           = DB::table('users')
                            ->join('designations', 'designations.id', '=', 'users.designation_id')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('users.id','users.name as un','users.username','users.email','users.proImage','designations.name as dn','roles.name as rn','users.created_at','users.updated_at')
                            ->where('users.id', $id)
                            ->first();
        return view('profile.show',compact('user'));
    }

    public function edit($id)
    {
        $data           = User::findorFail($id);
        $roles          = array();
   
        if($id == 1){       // user id = 1 ==> Super Admin
            $roles      = Role::pluck('name','name')->all();
        }else{
            $roles      = Role::where('id','!=',1)->pluck('name','name')->all();
            $userRoleId = $data->roles->pluck('id')->first();

            if($userRoleId !=2){  // role id = 2 ==> Admin
                $roles      = Role::where('id',$userRoleId)->pluck('name','name')->all();
            }

        }
        
   
        $userRole        = $data->roles->pluck('name','name')->all();

        return view('users.edit',compact('data','roles','userRole'));
    }


    public function update(UserRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = User::findOrFail($id);
        $input      = $request->all();

        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // password 
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input['password'] = $data['password'];
        }

        // image
        if(!empty($input['profile_pic'])){
            // $this->validate($request,['profile_pic'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
            // delete the previous image
            if($data['profile_pic']!=""){
                unlink(public_path('uploads/users/'.$data['profile_pic']));
            }

            // upload the new image
            $image                  = $request->file('profile_pic');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                      $image->move(public_path("uploads/users"),$new_name);
            $input['profile_pic']   = $new_name;
        }else{
            $input['profile_pic']   = $data['profile_pic'];
        }

        // update the entity
        $data->update($input);

        // delete previous roles
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        // assign new roles
        $data->assignRole($request->input('roles'));

        return response()->json(['success'=>$input['name']. ' updated successfully.']);
    }


    public function destroy(Request $request, User $user)
    {

        if($user->id == 1){
            return redirect()->back()->with(['error'=>'This is Super-Admin and cannot be deleted']);
        }
        $ids        = $user->id;
        $checkId    = Auth::user()->id;

        if($checkId == $ids){
            return redirect()->back()->with(['error'=>'This is logged in user, cannot be deleted']);
        }else{
            $user = User::find($ids);
             if($user['profile_pic']!=""){
                unlink(public_path('uploads/users/'.$user['profile_pic']));
            }
            $data = $user->delete();
            return redirect()->route('users.index')->with(['success_message'=>"User deleted successfully."]);
        }
    }
}
