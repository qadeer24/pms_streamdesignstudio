<?php
namespace App\Http\Controllers\API;

use DB;
use Carbon\Carbon;

use Response;
use Validator;
use Exception;
use App\Models\Area;
use App\Models\City;
use App\Models\People;
use App\Models\Rating;
use App\Models\Reason;
use App\Models\Booking;
use App\Models\History;
use App\Models\Province;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\People_detail;
use App\Models\People_rating;
use App\Models\People_vehicle;
use App\Http\Requests\MainRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TwilioSMSController;
use App\Http\Controllers\NotificationController;

class MainController extends Controller
{

    private function returnResponse($status,$msg,$data, $code) // done
    {
        return Response::json([
            'status'    => $status,
            'msg'       => $msg,
            "data"      => $data
        ], $code);
    }

    private function set_contact_no($cno) // done
    {
        if($cno[0] == "0"){
            $cno = "+92".(ltrim($cno, "0"));
        }
        return $cno;
    }

    public function register(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "register")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }
        $input               = $request->all();
        $otp                 = rand(1000, 9999);
        $temp_code           = rand(100000000, 999999999);
        $record              = People::where('contact_no', $request->contact_no)->first();

        if ( empty($record)){
            $input['otp']        = $otp;
            $input['temp_code']  = $temp_code;
            $input['fname']      = ucwords($input['fname']);
            $input['cnic']       = $input['cnic'];
            $input['password']   = Hash::make($input['password']);
            $record              = People::create($input);
        }else{
            $input['temp_code']  = $temp_code;
            $input['otp']        = $otp;
            $record->update($input);
        }

        // appending +92 with contact_no
        $cno = $this->set_contact_no($request->contact_no);
        
        // send sms using Twilio
        // (new TwilioSMSController)->index($cno, $otp);
        (new NotificationController)->send_otp($cno, $otp);

        $data               = array();
        $data['temp_code']  = $temp_code;
        return $this->returnResponse("success","OTP sent.",$data, 200);
       
    }

    public function login(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "login")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $record             = People::where('contact_no', $request->contact_no)->first();
        
        // checking password
        if(!(Hash::check($request->password, $record->password))) {
            return $this->returnResponse("failed","Validation errors",["Invalid password."], 404);
        }


        // otp will be sent to non-verified user.
        if($record->verified != 1) {
       
            $input['otp']        = rand(1000, 9999);
            $input['temp_code']  = rand(1000000000, 9999999999);
                                   $record->update($input);
            // appending +92 with contact_no
            $cno = $this->set_contact_no($request->contact_no);

            // send sms using Twilio
            // (new TwilioSMSController)->index($cno, $input['otp']);
            (new NotificationController)->send_otp($cno, $input['otp']);
            
            $data               = array();
            $data['temp_code']  = $input['temp_code'];
            return $this->returnResponse("success","OTP sent.",$data, 200);
        }
       
        // if above all condition 
        // delete all previous tokens of this ID
        // $record->tokens()
        //         ->where('tokenable_id', $record->id)
        //         ->where('name', 'people-token')
        //         ->delete();


        $data  = $this->return_login($request, $record);
        return $this->returnResponse("success","Logged in successfully.",$data, 200);
       

    }

    private function return_login($request, $record) // done
    {
        $data                          = array();
        $request->people_id            = $record->id;
        $record_details                = People_detail::where('people_id', $record->id)->first();
        $data['token']                 = $record->createToken('people-token')->plainTextToken;
        $data['fname']                 = (isset($record->fname)) ? ($record->fname) : "";
        $data['email']                 = (isset($record_details->email)) ? ($record_details->email) : "";
        $data['profile_pic']           = ((isset($record_details->profile_pic))) ? ( "public/uploads/peoples/".($record_details->profile_pic)) : ("public/uploads/no_image.png");
        $data['people_id']             = (isset($record->id)) ? ($record->id) : "";
        $data['type']                  = (((($record->type) =="Captain") || (($record->type) ==1))? "Captain" : "Passenger" );
        $data['role']                  = (((($record->role) =="Captain") || (($record->role) ==1))? "Captain" : "Passenger" ); // toggle role in app;
        $data['records']               = (($record->role  == "Captain") || ($record->role == 1) ) ? ($this->fetch_schedules($request,true)) :($this->fetch_bookings($request,true));
        $data['registration_complete'] = (!empty($record_details)) ? true : false;
        return $data;
    }

    public function verify_otp(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "verify_otp")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }
        
        ////// BEGIN :: un-comment when OTP apis purchased //////
        /* $record     = People::where('otp', $request->otp)
                            ->where('temp_code', $request->temp_code)
                            ->whereNull('forgot')
                            ->first();
                            
        if ( (empty($record))  || $record->otp == null  ){
            return $this->returnResponse("failed","Validation errors",["Invalid OTP."], 404);
        } */
        ////// END :: un-comment when OTP apis purchased //////

        $record     = People::where('temp_code', $request->temp_code)
                            ->whereNull('forgot')
                            ->first();

        if ( (!isset($record->id)) ){
            return $this->returnResponse("failed","Validation errors",["Invalid OTP."], 404);
        } 
        
        $data               = array();
        $data['otp']        = null;
        $data['verified']   = 1;
        $data['temp_code']  = null;
        $record->update($data);
        return $this->returnResponse("success","OTP verified.",[], 200);
    }

    // send_reset_otp
    public function forgot(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "forgot")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }
        $record             = People::where('contact_no', $request->contact_no)->first();

       // otp will be sent to non-verified user.
       $input['temp_code']  = rand(1000000000, 9999999999);
       $input['otp']        = rand(1000, 9999);
       $input['forgot']     = 1;
                              $record->update($input);

       // appending +92 with contact_no
       $cno = $this->set_contact_no($request->contact_no);

       // send sms using Twilio
       // (new TwilioSMSController)->index($cno, $input['otp']);
       (new NotificationController)->send_otp($cno, $input['otp']);

       $data              = array();
       $data['temp_code'] = $input['temp_code'];
       $data['name']      = "forgot";

       return $this->returnResponse("success","OTP sent.",$data, 200);
    }

    // store_reset_otp and return temp_code for update password
    public function forgot_otp(MainRequest $request)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "forgot_otp")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        ////// BEGIN :: un-comment when OTP apis purchased //////
        /* $record     = People::where('otp', $request->otp)
                            ->where('temp_code', $request->temp_code)
                            ->whereNotNull('forgot')
                            ->first();
                            
        if ( (empty($record))  || ($record->otp == null)  || (!(isset($record->id))) ){
            return $this->returnResponse("failed","Validation errors",["Invalid OTP."], 404);
        } */
        ////// END :: un-comment when OTP apis purchased //////

        $record     = People::where('temp_code', $request->temp_code)
                            ->whereNotNull('forgot')
                            ->first();

                            // dd($record);
                            
        if(!isset($record->id)){
            return $this->returnResponse("failed","Validation errors",["Invalid OTP."], 404);
        } 

        $input               = array();
        $input['otp']        = null;
        $input['verified']   = 1;
        $input['forgot']     = null;
        $input['temp_code']  = rand(1000000000, 9999999999);

        $record->update($input);

        $data              = array();
        $data['temp_code'] = $input['temp_code'];
        $data['name']      = "forgot_otp";
 
        return $this->returnResponse("success","Forgot OTP verified.",$data, 200);
    }

    // update_password
    public function update_password(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "update_password")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }
        $record              = People::where('temp_code', $request->temp_code)->first();
        $input               = array();
        $input['otp']        = null;
        $input['verified']   = 1;
        $input['password']   = Hash::make($request->password);
        $input['temp_code']  = null;

        $record->update($input);

        return $this->returnResponse("success","Password reset.",[], 200);
    }

    // toggle_role
    public function toggle_role(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "toggle_role")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $msg                 = "";
        $data                = [];
        $code                = 404;
        $status              = "failed";

        $record              = People::where('id', $request->people_id)->first();
      
        if(($record->type  != "Captain") && ((ucfirst($request->role)) == "Captain") ){
            $msg              = "Passenger can't be toggled to captain";

        }else if(( (ucfirst(strtolower($request->role))) != "Passenger")  && ((ucfirst(strtolower($request->role))) != "Captain")){
            $msg              = "Invalid toggle value!";

        }else{
            // BEGIN::update role of people from passenger to captain or vice versa
                $rec['role'] = ((((ucfirst(strtolower($request->role)))) == "Passenger") ? 0 : 1 ); // 1: captain and 0: passenger
                $record->update($rec);
            // END::update role of people from passenger to captain or vice versa

            if( $rec['role'] == 1 ){
                $records    = $this->fetch_schedules($request,true);
            }else{
                $records    = $this->fetch_bookings($request,true);
            }
            
            $msg                 = "Role toggled successfully";
            $status              = "success";
            $code                = 200;
            $data                = ['records' => $records];
           
        }

        return $this->returnResponse("success",$msg,$data, $code);

    }

    // store people detail to become captain
    public function store_details(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "store_details")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $record              = People::where('cnic', $request->cnic)->first();
        $detail              = People_detail::where('people_id', $record->id)->first();
        $vehicle             = People_vehicle::where('people_id', $record->id)->first();

        if (isset($detail->id) ){
            return $this->returnResponse("failed","Validation errors",["Details are already added."], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request,$record,$detail,$vehicle) {

                // BEGIN::update type of people from passenger to captain to create the ride
                    $rec['type']         = 1; // 1: captain and 0: passenger
                    $rec['role']         = 1; // 1: captain and 0: passenger
                    $record->update($rec);
                // END::update type of people from passenger to captain to create the ride

                // BEGIN::store detail in people_details table
                    $input                = $request->all();
                    $input['people_id']   = $record->id;
                    $rec                  = People_detail::create($input);
                // END::store detail in people_details table

                if( (array_key_exists("tax_pic",$input)) && (!empty($input['tax_pic']))  ){

                    // delete the previous image
                    if(isset($vehicle->tax_pic)){
                        if (file_exists( public_path('uploads/taxes/'.$vehicle->tax_pic) )){
                            unlink(public_path('uploads/taxes/'.$vehicle->tax_pic));
                        }
                    }

                    // move the image to the taxes directory
                    $image                  = $request->file('tax_pic');
                    $input['tax_pic']       = rand().'.'.$image->getClientOriginalExtension();
                                              $image->move(public_path("uploads/taxes"),$input['tax_pic']);
                }

                // BEGIN::store detail in people_details table
                    $rec                = People_vehicle::create($input);
                // END::store detail in people_details table

            });

                
            if(is_null($exception)) {

                $vehicle    = People_vehicle::where('people_id', $record->id)->first();
                $vehicle_id = (isset($vehicle->id))? ($vehicle->id) :null ; 

                $data       = ([
                                        'fname'         => $record->fname,
                                        'people_id'     => $record->id,
                                        'type'          => "Captain",
                                        'vehicle_id'    => $vehicle_id
                                    ]);

                return $this->returnResponse("success","Details added successfully.",$data, 200);
              
            }else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);

        }
    }
    
    // fetch provinces alongwith cities
    public function fetch_provinces() // done
    {

        $records        = array();
        $all_records    = array();

        $provinces      = Province::orderBy('id')
                            ->select('id','name')
                            ->where('active',1)
                            ->get();

        foreach ($provinces as $key => $province) {
            $records            = (object) array(
                                    "province_id"       => ((isset($province->id)) ? $province->id : "" ),
                                    "province_name"     => ((isset($province->name)) ? $province->name : "" ),
                                    "cities"            => $province->cities($province->id)
                                );

            array_push($all_records, $records);
        }

        $data   = (['provinces' =>  $all_records]);
        return $this->returnResponse("success","Provinces fetched successfully.",$data, 200);

    }
    
    // fetch cities only
    public function fetch_cities() // done
    {
        $record     = City::select('id','name','lat','lng')->where('active',1)->get()->toArray();
        $data       = (['cities' =>  $record]);

        return $this->returnResponse("success","Cities fetched successfully.",$data, 200);
    }

    // update profile :: updating all people profile inputs
    public function update_profile(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "update_profile")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $token              = null;
        $record             = People::where('contact_no', $request->contact_no)->first();
        $record_details     = People_detail::where('people_id', $record->id)->first();

        // BEGIN :: checking is password valid 
        if(isset($request->old_password)){

            if(!(isset($request->new_password))){
                return $this->returnResponse("failed","Validation errors",["Please enter new password."], 404);
            }

            if(!(Hash::check($request->old_password, $record->password))) {
                return $this->returnResponse("failed","Validation errors",["Invalid password."], 404);
            }
        }

        // END :: checking is password valid 


        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request,$record,$record_details,$token) {
          
                // update profile with or without password 
                if(isset($request->old_password)){
                
                    // update fname and password
                    $record->update([
                        'fname'      => $request->fname,
                        'password'   => Hash::make($request->new_password),
                    ]);
                    
                   
                    // delete all previous tokens of this ID
                    $record->tokens()
                        ->where('tokenable_id', $record->id)
                        ->where('name', 'people-token')
                        ->delete();

                }else{
                    $record->update(['fname'  => ($request->fname)]);
                }
      
                // input variables 
                $req                = $request->all();
                $input              = $request->all();   
                $req['people_id']   = $record->id;

                // BEING :: uploading image
                if( (array_key_exists("profile_pic",$input)) && (!empty($input['profile_pic']))  ){
        
                    // delete the previous image
                    if(isset($record_details->profile_pic)){
                        if (file_exists( public_path('uploads/peoples/'.$record_details->profile_pic) )){
                            unlink(public_path('uploads/peoples/'.$record_details->profile_pic));
                        }
                    }

                    $image                  = $request->file('profile_pic');
                    $input['profile_pic']   = rand().'.'.$image->getClientOriginalExtension();
                                              $image->move(public_path("uploads/peoples"),$input['profile_pic']);
        

                    // if details not exists
                    if ($record_details !== null) {
                        $record_details->update([
                            'email'       => $request->email,
                            'profile_pic' => $input['profile_pic']
                        ]);
                    } else {
                        $record_details = People_detail::create([
                            'people_id'   => $record->id,
                            'email'       => $request->email,
                            'profile_pic' => $input['profile_pic']
                        ]);
                    }

                    // People_detail::updateOrCreate(
                    //     ['people_id'    => $record->id],
                    //     ['email'        => $request->email],
                    //     ['profile_pic'  => $input['profile_pic']]
                    // );
                 
                }else{
                    // People_detail::updateOrCreate(
                    //     ['people_id'    => $record->id],
                    //     ['email'        => $request->email]
                    // );

                    // if details not exists
                    if ($record_details !== null) {
                        $record_details->update([
                            'email'       => $request->email
                        ]);
                    } else {
                        $record_details = People_detail::create([
                            'people_id'   => $record->id,
                            'email'       => $request->email,
                        ]);
                    }
                    
                }
            });

            
            if(is_null($exception)) {
                // create new token for this ID
                
                $record_details     = People_detail::where('people_id', $record->id)->first();
                $token              = (isset($request->old_password)) ? $record->createToken('people-token')->plainTextToken: null;
                $pth                = ((isset($record_details->profile_pic))) ? ( "public/uploads/peoples/".($record_details->profile_pic)) : ("public/uploads/no_image.png");
                $email              = (isset($record_details->email)) ? ($record_details->email):"" ;

                if($token != null){

                    $data   = ([
                                        'token'         => $token,
                                        'people_id'     => $record->id,
                                        'fname'         => $record->fname,
                                        'contact_no'    => $record->contact_no,
                                        'email'         => $email,
                                        'profile_pic'   => $pth
                                    ]);
                    return $this->returnResponse("success","Profile updated & new token generated successfully.",$data, 200);

                }else{

                    $data   = ([
                                        'people_id'     => $record->id,
                                        'fname'         => $record->fname,
                                        'contact_no'    => $record->contact_no,
                                        'email'         => $email,
                                        'profile_pic'   => $pth
                                    ]);
                    return $this->returnResponse("success","Profile updated successfully.",$data, 200);
                    
                }
            }else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);
            // return $this->returnResponse("failed","Validation errors",$e, 404);
        }
    }
    
    // storing the detail of the people vechicle but not more than 3 vehicles
    public function store_people_vehicle(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "store_people_vehicle")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        // More than 3 vehicles can not be added
        $people_vehicles        =  People_vehicle::where('people_vehicles.people_id',$request->people_id)->count();
        if($people_vehicles >= 3){
            return $this->returnResponse("failed","Validation errors",["You already added 3 vehicles."], 404);
        }
        
        $rcd                    = $request->all();

        if( (array_key_exists("tax_pic",$rcd)) && (!empty($rcd['tax_pic']))  ){
            // move the image to the taxes directory
            $image              = $request->file('tax_pic');
            $rcd['tax_pic']     = rand().'.'.$image->getClientOriginalExtension();
                                    $image->move(public_path("uploads/taxes"),$rcd['tax_pic']);
        }


        // BEGIN::store detail in People_vehicle table
            $rcd                = People_vehicle::create($rcd);
        // END::store detail in People_vehicle table


        $data                   = ([
                                            'people_id'            => $rcd->people_id,
                                            'vehicle_id'           => $rcd->id,
                                            'vehicle_registration' => $rcd->vehicle_registration,
                                            'make'                 => $rcd->make,
                                            'modal'                => $rcd->modal,
                                            'car_year'             => $rcd->car_year,
                                            'color'                => $rcd->color,
                                            'seat'                 => $rcd->seat
                                        ]);


        return $this->returnResponse("success","Vehicle stored successfully.",$data, 200);
    }

    // updating the details of the people vehicle
    public function update_people_vehicle(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "update_people_vehicle")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $pth                    = "public/uploads/no_image.png";
        $record                 = $request->all();  
        $people_vehicle         = People_vehicle::where('id',$request->vehicle_id)->first();

       
        // uploading image
        if( (array_key_exists("tax_pic",$record)) && (!empty($record['tax_pic']))  ){

            // delete the previous image
            if(isset($people_vehicle->tax_pic)){
                if (file_exists( public_path('uploads/taxes/'.$people_vehicle->tax_pic) )){
                    unlink(public_path('uploads/taxes/'.$people_vehicle->tax_pic));
                }
            }

            // move the image to the licenses directory
            $image                  = $request->file('tax_pic');
            $record['tax_pic']      = rand().'.'.$image->getClientOriginalExtension();
                                        $image->move(public_path("uploads/taxes"),$record['tax_pic']);
        }

        $people_vehicle->update($record);

        if(isset($people_vehicle->tax_pic)){
            $pth = "public/uploads/taxes/".($people_vehicle->tax_pic);  
        }

        $data   = ([
                            'people_id'            => $people_vehicle->people_id,
                            'vehicle_id'           => $people_vehicle->id,
                            'vehicle_registration' => $people_vehicle->vehicle_registration,
                            'make'                 => $people_vehicle->make,
                            'car_year'             => $people_vehicle->car_year,
                            'seat'                 => $people_vehicle->seat,
                            'color'                => $people_vehicle->color,
                            'modal'                => $people_vehicle->modal,
                            'tax_pic'              => $pth
                        ]);
        return $this->returnResponse("success","Vehicle updated successfully.",$data, 200);
    }

    // fetching the all people vehicle via people_id
    public function fetch_people_vehicle(MainRequest $request)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_people_vehicle")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $people_vehicles        =  People_vehicle::where('people_vehicles.people_id',$request->people_id)
                                    ->select(
                                            'id as vehicle_id',
                                            'vehicle_registration',
                                            'make',
                                            'modal',
                                            'car_year',
                                            'color',
                                            'seat',
                                            'active', // active: 1 OR active : 0

                                            DB::raw('(CASE 
                                                WHEN isNULL(people_vehicles.tax_pic) THEN "public/uploads/no_image.png" 
                                                ELSE CONCAT("public/uploads/taxes/",people_vehicles.tax_pic)
                                                END) AS tax_pic'
                                            )
                                            
                                        )
                                    ->get();
                            
        $tot_vehicle    = (count($people_vehicles));
                                    
        if(count($people_vehicles) < 3){
            $people_vehicles = (count($people_vehicles) <1) ?  $people_vehicles->push(((object) array("vehicle_id" => "0"))) : $people_vehicles;
        }
        
        if(count($people_vehicles) > 0){
            // $people_vehicles = (count($people_vehicles) <=3) ?  $people_vehicles->push(((object) array("vehicle_id" => "0"))) : $people_vehicles;
            $data   = ([
                            'tot_vehicle'     => $tot_vehicle,
                            'people_vehicles' =>  $people_vehicles 
                        ]);

            return $this->returnResponse("success","vehicle fetched by people successfully.",$data, 200);
        }else{
            $data   = (['people_vehicles' =>  [] ]);
            return $this->returnResponse("success","No vehicle found.",$data, 200);
        }
    }

    // store the history of schedule 
    public function store_history($people_id,$type,$schedule_id,$booking_id,$detail=null,$status_id)  // done
    {
        // BEGIN::store history
            $req                = array();
            $req['people_id']   = $people_id;
            $req['type']        = $type;
            $req['schedule_id'] = $schedule_id;
            $req['booking_id']  = $booking_id;
            $req['detail']      = $detail;
            $req['status_id']   = $status_id;
            $req                = History::create($req);
        // END::store history
        return true;
    }

    // store the schedule of a captain
    public function store_schedule(MainRequest $request)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "store_schedule")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        if(($request->dropoff_area_id)  ==  ($request->pickup_area_id)){
            return $this->returnResponse("failed","Validation errors",["Pickup & dropoff areas cannot be same."], 404);
        }

        $people_vehicle         = People_vehicle::where('id',$request->vehicle_id)
                                    ->select('seat')
                                    ->first();
        
        $record                 = People::where('id', $request->people_id)
                                    ->where('type', 1) // 1: captain
                                    ->first();

        $schedule               = Schedule::where('captain_id', $request->people_id)
                                    ->where('status_id','!=', env('STATUS_CANCEL_ID')) // cancelled
                                    ->where('schedule_time', $request->schedule_time)
                                    ->where('schedule_date', $request->schedule_date)
                                    ->first();


        if (!(isset($people_vehicle->seat)) ){
            return $this->returnResponse("failed","Validation errors",["Vehicle seat not found."], 404);
        }

        
        if ( ($request->vacant_seat) > ($people_vehicle->seat)  ){
            $msg = "You can't enter more than " . ($people_vehicle->seat) . " seats";
            return $this->returnResponse("failed","Validation errors",[$msg], 404);
        }


        if (!(isset($record->id)) ){
            return $this->returnResponse("failed","Validation errors",["Only captain can create a ride, please add detail first."], 404);
        }

        if ((isset($schedule->id)) ){
            return $this->returnResponse("failed","Validation errors",["Schedule is already added."], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request, $record) {

                // BEGIN::store detail in people_details table
                    $schedule                = $request->all();
                    $schedule['captain_id']  = $record->id;
                    $schedule['status_id']   = 1;  // 1: Scheduled
                    $schedule                = Schedule::create($schedule);
                // END::store detail in people_details table

                $this->store_history($record->id,1,$schedule->id,null,null,1);
            });

            if(is_null($exception)) {
                return $this->returnResponse("success","Schedule added successfully.",[], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);
        }
    }

    // cancel the schedule of a captain
    public function cancel_schedule(MainRequest $request)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "cancel_schedule")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $record             = Schedule::where('schedules.active',1)
                                ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.id',$request->schedule_id)
                                ->where('schedules.status_id','<=',3)
                                ->first();
                                
        // is schedule exist
        if (!(isset($record->id)) ){
            return $this->returnResponse("failed","Validation errors",["No schedule found."], 404);
        }

        try {
            $exception = DB::transaction(function()  use ($request,$record) {

                // BEGIN::update schedule to cancel
                    $input                      = $request->all();
                    $input['status_id']         = env('STATUS_CANCEL_ID'); 
                                                  $record->update($input);
                // END::update schedule to cancel

                // BEGIN::store cancel schedule history
                    $this->store_history($request->people_id,1,$request->schedule_id,null,null,env('STATUS_CANCEL_ID'));
                // END::store cancel schedule history

                
                // BEGIN::fetch all bookings against this schedule id
                    $bookings           = Booking::where('bookings.active',1)
                                            ->where('bookings.schedule_id',$request->schedule_id)
                                            ->where('bookings.status_id','<=',3)
                                            ->get();
                // END::fetch all bookings against this schedule id
               

                // BEGIN::cancel all bookings against this schedule id
                    $upd                = Booking::where('bookings.active',1)
                                            ->where('bookings.schedule_id',$request->schedule_id)
                                            ->where('bookings.status_id','<=',3)
                                            ->update(['status_id' =>  env('STATUS_CANCEL_ID') ]);
                // END::cancel all bookings against this schedule id


                // BEGIN::store cancel history of booking because schedule is cancelled
                    foreach ($bookings as $key => $booking) {
                        $this->store_history($booking->passenger_id,0,$request->schedule_id,$booking->id,"Schedule cancelled",env('STATUS_CANCEL_ID'));
                    }
                // END::store cancel history of booking because schedule is cancelled

            });
            if(is_null($exception)) {
                return $this->returnResponse("success","Schedule cancelled successfully.",[], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);
        }
    }

    public function store_booking(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "store_booking")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $schedule           = Schedule::where('schedules.id', $request->schedule_id)
                                ->leftjoin('statuses', 'statuses.id', '=', 'schedules.status_id')                                
                                ->select(
                                        'schedules.id',
                                        'schedules.captain_id',
                                        'schedules.status_id',
                                        'schedules.vacant_seat',
                                        'statuses.name as status_name',
                                    )
                                ->first();

        $booking            = Booking::where('schedule_id', $schedule->id)
                                ->where('status_id','!=', env('STATUS_CANCEL_ID')) //  cancelled
                                ->sum('book_seat');

        if((isset($schedule->status_id))  && (($schedule->status_id) > 2)){
            $msg = 'You cannot schedule because captain '.($schedule->status_name);
            return $this->returnResponse("failed","Validation errors",[ $msg], 404);
        }

        if(($schedule->captain_id) == ($request->people_id) ){
            return $this->returnResponse("failed","Validation errors",["Captain cannot book his own drive"], 404);
        }

        if ( (isset($schedule->vacant_seat)) && ( (($booking) >= ($schedule->vacant_seat)) || (($request->book_seat) > ($schedule->vacant_seat))  || ( ( ($request->book_seat) + ($booking) ) > ($schedule->vacant_seat) ) ) ){
            return $this->returnResponse("failed","Validation errors",["No vacant seat available"], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request) {

                // BEGIN::store detail in people_details table
                    $booking                    = $request->all();
                    $booking['passenger_id']    = $request->people_id;
                    $booking['status_id']       = 1;  // 1: Scheduled
                    $booking                    = Booking::create($booking);
                // END::store detail in people_details table

                $this->store_history($request->people_id,0,$request->schedule_id,$booking->id,null,1);
            });
            if(is_null($exception)) {
                return $this->returnResponse("success","Booking added successfully.",[], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);
        }
    }

    public function cancel_booking(MainRequest $request)  // done
    {

        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "cancel_booking")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $record             = Booking::where('bookings.active',1)
                                ->where('bookings.passenger_id',$request->people_id)
                                ->where('bookings.id',$request->booking_id)
                                ->where('bookings.status_id','<=',3)
                                ->first();
                                
        // is booking exist
        if(!(isset($record->id))){
            return $this->returnResponse("failed","Validation errors",["No booking found."], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request,$record) {

                // BEGIN::update schedule to cancel
                    $input                      = $request->all();
                    $input['status_id']         = env('STATUS_CANCEL_ID'); 
                                                  $record->update($input);
                // END::update schedule to cancel

                $this->store_history($request->people_id,0,$record->schedule_id,$request->booking_id,null,env('STATUS_CANCEL_ID'));
            });
            if(is_null($exception)) {
                return $this->returnResponse("success","Booking cancelled successfully.",[], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);
        }
    }

    public function count_schedules($captain_id) // done  --commented
    {

        return  Schedule::where('schedules.active',1)
                        ->where('schedules.captain_id',$captain_id)
                        ->where('schedules.status_id','<=',3)
                        ->count();
    }
    
    public function count_bookings($schedule_id) // done
    {

        $seats      = Booking::where('bookings.schedule_id',$schedule_id)
                            ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                            ->sum('book_seat');
                            
        return    $seats;
    }

    public function fetch_schedule_of_booking($schedule_id)   // done
    {
        
        $schedule           = Schedule::where('schedules.active',1)
                                ->where('schedules.id',$schedule_id)
                                // ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'schedules.captain_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                            'people.fname as cap_name',
                                            'people_details.profile_pic',
                                            'schedules.fare',
                                            'people_vehicles.modal as modal',
                                            'people_vehicles.make as make',
                                            'schedules.vacant_seat',
                                            DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                            DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                        )
                                ->first();
        return  $schedule;

    }

    public function fetch_bookings(MainRequest $request, $inner_call = FALSE)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_bookings")) ){
            if(!$inner_call){ // calling from api
                return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
            }
        }

        $bookings           = Booking::where('bookings.active',1)
                                ->where('bookings.passenger_id',$request->people_id)
                                ->where('bookings.status_id','<=',3)
                                ->select(
                                            'bookings.id as booking_id',
                                            'bookings.schedule_id as schedule_id',
                                        )
                                ->get();
                                
        foreach ($bookings as $key => $booking) {

            $rating                         = People_rating::where('people_ratings.schedule_id',$booking->schedule_id)
                                                ->avg('people_ratings.rating_stars');

            $seats                          = Booking::where('bookings.schedule_id',$booking->schedule_id)
                                                ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                                                ->sum('book_seat');

            // $bookings[$key]->vacant_seat    = (($booking->vacant_seat) -  $seats);
            $bookings[$key]->rating         = round($rating);

            
            $schdl                          = $this->fetch_schedule_of_booking($bookings[$key]->schedule_id );

            $bookings[$key]->fare           = (isset($schdl->fare)) ? $schdl->fare : 0;
            $bookings[$key]->vacant_seat    = (isset($schdl->vacant_seat)) ? (($schdl->vacant_seat)) : 0;
            $bookings[$key]->booked_seat    = (isset($seats)) ? ((int)$seats) : 0;
            $bookings[$key]->remaining_seat = (isset($schdl->vacant_seat)) ? (($schdl->vacant_seat) -  $seats) : 0;
            // $bookings[$key]->vacant_seat    = (isset($schdl->vacant_seat)) ? (($schdl->vacant_seat) -  $seats) : 0;
            $bookings[$key]->pickup_address = (isset($schdl->pickup_address)) ? $schdl->pickup_address : null;
            $bookings[$key]->dropoff_address= (isset($schdl->dropoff_address)) ? $schdl->dropoff_address : null;
            $bookings[$key]->cap_name       = (isset($schdl->cap_name)) ? $schdl->cap_name : null;
            $bookings[$key]->profile_pic    = (isset( $schdl->profile_pic)) ? ("public/uploads/peoples/".($schdl->profile_pic)) :( "public/uploads/no_image.png");
            $bookings[$key]->make           = (isset($schdl->make)) ? $schdl->make : null;
            $bookings[$key]->modal          = (isset($schdl->modal)) ? $schdl->modal : null;

        }
     

        $data = ([ 'bookings' => $bookings]);
        if($inner_call){
            return $data;
        }else{
            return $this->returnResponse("success","Bookings fetched for passenger successfully.",$data, 200);
        }

    }

    public function fetch_schedules(MainRequest $request, $inner_call = FALSE)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_schedules")) ){
            if(!$inner_call){ // calling from api
                return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
            }
        }

        $record              = People::where('id', $request->people_id)->first();

        if(((ucfirst(strtolower($request->role)))) == "Captain"){
            $rec['role'] = 1;
            $record->update($rec);
        }

        $schedules          = Schedule::where('schedules.active',1)
                                ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'schedules.captain_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                            'schedules.id as schedule_id',
                                            'schedules.fare',
                                            'schedules.vacant_seat',
                                            
                                            'people.fname as cap_name',

                                            'people_vehicles.make',
                                            'people_vehicles.modal',
                                            'people_details.profile_pic',
                                            DB::raw('(CASE 
                                                WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                                ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                                END) AS profile_pic'
                                            ),

                                            DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                            DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                        )
                                ->get();



        foreach ($schedules as $key => $schedule) {
            $rating     = People_rating::where('people_ratings.schedule_id',$schedule->schedule_id)->avg('people_ratings.rating_stars');
            $seats      = Booking::where('bookings.schedule_id',$schedule->schedule_id)
                            ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                            ->sum('book_seat');

            // $schedules[$key]->profile_pic   = (isset( $schedule->profile_pic)) ? ("public/uploads/peoples/".($schedule->profile_pic)) :( "public/uploads/no_image.png");

            $schedules[$key]->vacant_seat   = (($schedule->vacant_seat) -  $seats);
            $schedules[$key]->rating        = round($rating);
        }

        $data   = ([
                    'schedules'     => $schedules,
                    // 'tot_schedules' =>$this->count_schedules($request->people_id),
                    'tot_schedules' => count($schedules)
                ]);

        if($inner_call){
            return $data;
        }else{
            return $this->returnResponse("success","Schedules fetched for captain successfully.",$data, 200);
        }
    }

    public function fetch_schedule_by_people(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_schedule_by_people")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $schedules  = Schedule::where('schedules.active',1)
                                ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.id as schedule_id',
                                        
                                        'schedules.fare',

                                        'schedules.vacant_seat',
                                        'schedules.pickup_lat',
                                        'schedules.pickup_lng',
                                        'schedules.dropoff_lat',
                                        'schedules.dropoff_lng',
                                        
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();

        foreach ($schedules as $key => $schedule) {
            $seats                          = Booking::where('bookings.schedule_id',$schedule->schedule_id)
                                                ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                                                ->sum('book_seat');
            $schedules[$key]->vacant_seat    = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) ) : 0;
            $schedules[$key]->booked_seat    = (isset($seats)) ? ((int)$seats) : 0;
            $schedules[$key]->remaining_seat = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) -  $seats) : 0;
        }

       
        $data   = ([
                    'schedules' => $this->append_rating($schedules),
                    // 'tot_schedules' =>$this->count_schedules($request->people_id),
                    'tot_schedules' => count($schedules)
                ]);

        return $this->returnResponse("success","Schedules fetched by people successfully.",$data, 200);
    }

    public function fetch_schedule_by_city(MainRequest $request)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_schedule_by_city")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }
        
        $schedules  = Schedule::where('schedules.active',1)->orderBy('schedules.id','DESC')
                                // ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.pickup_city_id',$request->pickup_city_id)
                                ->where('schedules.dropoff_city_id',$request->dropoff_city_id)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.id as schedule_id',
                                        'schedules.fare',
                                        'schedules.vacant_seat',
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();

        foreach ($schedules as $key => $schedule) {
            $seats                          = Booking::where('bookings.schedule_id',$schedule->schedule_id)
                                                ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                                                ->sum('book_seat');
            $schedules[$key]->vacant_seat    = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) ) : 0;
            $schedules[$key]->booked_seat    = (isset($seats)) ? ((int)$seats) : 0;
            $schedules[$key]->remaining_seat = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) -  $seats) : 0;
        }


        $data   = ([
                    'schedules' => $this->append_rating($schedules),
                    // 'tot_schedules' =>$this->count_schedules($request->people_id),
                    'tot_schedules' => count($schedules)
                ]);

        return $this->returnResponse("success","Schedules fetched by city successfully.",$data, 200);
    }

    public function fetch_schedule_by_date(MainRequest $request) // done  --not used in system
    {

        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_schedule_by_date")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }


        $schedules  = Schedule::where('schedules.active',1)->orderBy('schedules.id','DESC')
                                // ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.pickup_city_id',$request->pickup_city_id)
                                ->where('schedules.dropoff_city_id',$request->dropoff_city_id)
                                ->where('schedules.schedule_date',$request->schedule_date)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.captain_id',
                                        'schedules.id as schedule_id',
                                        'schedules.fare',
                                        'schedules.vacant_seat',
                                        
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();

        foreach ($schedules as $key => $schedule) {
            $seats                          = Booking::where('bookings.schedule_id',$schedule->schedule_id)
                                                ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                                                ->sum('book_seat');
            $schedules[$key]->vacant_seat    = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) ) : 0;
            $schedules[$key]->booked_seat    = (isset($seats)) ? ((int)$seats) : 0;
            $schedules[$key]->remaining_seat = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) -  $seats) : 0;
        }
        
        $data   = ([
                    'schedules' => $this->append_rating($schedules),
                    // 'tot_schedules' =>$this->count_schedules($request->people_id),
                    'tot_schedules' => count($schedules)
                ]);

        return $this->returnResponse("success","Schedules fetched by date successfully.",$data, 200);

    }

    public function fetch_schedule_by_time(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_schedule_by_time")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }
        
        $end_time   = Carbon::createFromFormat('H', $request->end_time);
        $start_time = Carbon::createFromFormat('H', $request->start_time);
        // $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->toDateTimeString();
        // $end_date   = Carbon::createFromFormat('Y-m-d', $request->end_date);
        
        $end_time    = Carbon::parse($end_time)->format('H:i');
        $start_time  = Carbon::parse($start_time)->format('H:i');
        $end_date    = Carbon::parse($request->end_date)->format('Y-m-d');
        $start_date  = Carbon::parse($request->start_date)->format('Y-m-d');

        $schedules  = Schedule::where('schedules.active',1)->orderBy('schedules.id','DESC')
                                // ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.pickup_city_id',$request->pickup_city_id)
                                ->where('schedules.dropoff_city_id',$request->dropoff_city_id)
                                ->whereBetween('schedules.schedule_date',[$start_date,$end_date])
                                ->whereBetween('schedules.schedule_time',[$start_time,$end_time])
                                ->where('schedules.status_id','<=',3) 
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.captain_id',
                                        'schedules.id as schedule_id',
                                        'schedules.fare',
                                        'schedules.vacant_seat',
                                        'schedules.schedule_date',
                                        'schedules.schedule_time',
                                        
                                        'schedules.start_time',
                                        'schedules.end_time',
                                        'schedules.start_date',
                                        'schedules.end_date',
                                        
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();
        // dd($schedules);
        $sh                 = array();
        
        foreach ($schedules as $key => $value) {
            $schdle_id  = $value->schedule_id;
            $bkings     = $this->count_bookings($schdle_id);
            // if( ($value->vacant_seat)  > $bkings ){  // un-comment it, if you want to NOT to show those rides whose all seat are  booked
                array_push($sh,$value);
            // }
        }

        foreach ($schedules as $key => $schedule) {
            $seats                          = Booking::where('bookings.schedule_id',$schedule->schedule_id)
                                                ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                                                ->sum('book_seat');
            $schedules[$key]->vacant_seat    = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) ) : 0;
            $schedules[$key]->booked_seat    = (isset($seats)) ? ((int)$seats) : 0;
            $schedules[$key]->remaining_seat = (isset($schedule->vacant_seat)) ? (($schedule->vacant_seat) -  $seats) : 0;
        }
        
        $data   = ([
            'schedules'     => $this->append_rating($sh),
            'tot_schedules' => count($sh)
            // 'tot_schedules' =>$this->count_schedules($request->people_id),
        ]);

        return $this->returnResponse("success","Schedules fetched by time successfully.",$data, 200);
    }

    public function fetch_cancel_reasons(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_cancel_reasons")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $reasons      = Reason::orderBy('id')
                            ->select(
                                        'id as reason_id',
                                        'name as reason_name'
                                    )
                            ->where('active',1)
                            ->get();

        $data   = (['reasons' =>  $reasons]);

        return $this->returnResponse("success","Reason fetched successfully.",$data, 200);

    }
    
    // append rating index to an array
    public function append_rating($schedules)  // done
    {
       
        foreach ($schedules as $key => $schedule) {
            $rating                     = People_rating::where('people_ratings.schedule_id',$schedule->schedule_id)->avg('people_ratings.rating_stars');
            $schedules[$key]->rating    = round($rating);
        }

        return $schedules;
    }

    public function fetch_ratings(MainRequest $request)  // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_ratings")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }
        
        $ratings      = Rating::orderBy('id')
                            ->select(
                                        'id as rating_id',
                                        'name as rating_name',
                                        'star as rating_star',
                                        'comment as rating_comment'
                                    )
                            ->where('active',1)
                            ->get();

                            
        $data   = (['ratings' =>  $ratings]);
        return $this->returnResponse("success","Rating fetched successfully.",$data, 200);
    }

    public function store_ratings(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "store_ratings")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        // BEGIN :: Captain cannot rating his own ride
            $schdl      = Schedule::where('schedules.active',1)
                            ->where('schedules.id',$request->schedule_id)
                            ->where('schedules.captain_id',$request->people_id)
                            ->first();

            if(isset($schdl->id)){
                return $this->returnResponse("failed","Validation errors",["Captain cannot rate his own ride"], 404);
            }
        // END :: Captain cannot rating his own ride


        // BEGIN :: Passenger cannot rate twice the same ride
            $ppl_rtng   = People_rating::where('people_ratings.active',1)
                            ->where('people_ratings.schedule_id',$request->schedule_id)
                            ->where('people_ratings.passenger_id',$request->people_id)
                            ->first();

            if(isset($ppl_rtng->id)){
                return $this->returnResponse("failed","Validation errors",["One booking cannot be rated twice by same user"], 404);
            }
        // END :: Passenger cannot rate twice the same ride


        // BEGIN :: Passenger cannot rate twice the same ride
            $bkngs      = Booking::where('bookings.active',1)
                            ->where('bookings.schedule_id',$request->schedule_id)
                            ->where('bookings.passenger_id',$request->people_id)
                            ->where('status_id','=', env('STATUS_CANCEL_ID')) // cancelled ride can not be rated
                            ->first();

            if(isset($ppl_rtng->id)){
                return $this->returnResponse("failed","Validation errors",["You cannot the rate non-booked or cancelled ride"], 404);
            }
        // END :: Passenger cannot rate twice the same ride



        // checking valid index (s)
        if( isset($request->rating_stars) && (count($request->rating_stars) > 0)){
            foreach ($request->rating_stars as $rtng_id => $rating_star) {
                $rtng = Rating::where('id', $rtng_id)->first();
                if(!isset($rtng->id)){
                    $msg = $rtng_id . " is invalid rating index.";
                    return $this->returnResponse("failed","Validation errors",[$msg], 404);
                }
            }
        }else{
            return $this->returnResponse("failed","Validation errors",["Rating stars field is required."], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request) {
                        
                $schdl = Schedule::where('schedules.active',1)->select('schedules.captain_id')
                                ->where('schedules.id',$request->schedule_id)
                                ->first();

                foreach ($request->rating_stars as $rtng_id => $rating_star) {
                    $ppl_rtng               = new People_rating;
                    $ppl_rtng->captain_id   = isset($schdl->captain_id) ? $schdl->captain_id : 0;
                    $ppl_rtng->schedule_id  = isset($request->schedule_id) ? $request->schedule_id : 0;
                    $ppl_rtng->passenger_id = isset($request->people_id) ? $request->people_id : 0;
                    $ppl_rtng->rating_id    = isset($rtng_id) ? $rtng_id : 0;
                    $ppl_rtng->rating_stars = isset($rating_star) ? $rating_star : 0;
                    $ppl_rtng->save();
                }
               
            });
            if(is_null($exception)) {
                return $this->returnResponse("success","Ratings stored successfully.",[], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);
        }
    }

    private function count_all_bkngs($schedule_id) // done 
    {
        $record             = Booking::where('bookings.active',1)
                                ->where('bookings.schedule_id',$schedule_id)
                                ->count();  
        return $record;
    }

    private function count_cmpltd_cncld_bkngs($schedule_id) // done
    {
        $record             = Booking::where('bookings.active',1)
                                ->where('bookings.schedule_id',$schedule_id)
                                ->where('bookings.status_id','>',3) // 4: completed and 5: canceled
                                ->count();  
        return $record;
    }

    private function count_incmpltd_bkngs($schedule_id) // done
    {
        $record             = Booking::where('bookings.active',1)
                                ->where('bookings.schedule_id',$schedule_id)
                                ->where('bookings.status_id','<=',3) // 1: scheduled, 2: Waiting, 3: On the way
                                ->count();  
        return $record;
    }
    
    public function mark_booking_complete(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "mark_booking_complete")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $record             = Booking::where('bookings.active',1)
                                ->where('bookings.passenger_id',$request->people_id)
                                ->where('bookings.id',$request->booking_id)
                                ->where('bookings.status_id','<=',3)
                                ->first();

       
                                
        // is booking exist
        if(!(isset($record->id))){
            return $this->returnResponse("failed","Validation errors",["No booking found."], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request,$record) {

                // BEGIN::update mark booking to complete
                    $input                      = $request->all();
                    $input['status_id']         = 4; // completed 
                                                  $record->update($input);
                // END::update mark booking to complete
                $this->store_history($request->people_id,0,$record->schedule_id,$request->booking_id,null,4);


                // BEGIN :: Schdule Complete
                    $cmpltd_cncld_bkngs = isset($record->schedule_id) ? $this->count_cmpltd_cncld_bkngs($record->schedule_id) : 0;
                    $count_all_bkngs    = isset($record->schedule_id) ? $this->count_all_bkngs($record->schedule_id) : 0;
                    // $incmpltd_bkngs     = isset($record->schedule_id) ? $this->count_incmpltd_bkngs($record->schedule_id) : 0;
                
                    // mark the schedule completed.
                    if($cmpltd_cncld_bkngs >= $count_all_bkngs){
                        $schdl   = Schedule::where('id',$record->schedule_id)->first();
                        $schdl->update(['status_id' => 4]); // schedule completed
                        $cptn_id = isset($schdl->captain_id) ? $schdl->captain_id : 0;
                        $this->store_history($cptn_id,1,$record->schedule_id,null,null,4);  // store the schedule compeletion history
                    }

                // END :: Schedule Completed
            });
            if(is_null($exception)) {
                return $this->returnResponse("success","Booking marked as completed successfully.",[], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return $this->returnResponse("failed","Validation errors",["Something went wrong."], 404);
        }
    }


    protected function fetch_schedules_history(Request $request)
    {

        $records     = History::orderBy('histories.created_at')
                        ->select('id', 'people_id','schedule_id','booking_id','detail','status_id', 'type')
                        ->whereNotNull('schedule_id')
                        ->whereNull('booking_id')
                        ->where('type', 1)  // type: 1  = Captain
                        ->where('people_id', $request->people_id)
                        ->where('status_id', 4) // completed 
                        ->get();

        foreach ($records as $key => $record) {
            $records[$key]->cap_name        = isset($record->schedule->captain->fname) ? ($record->schedule->captain->fname) : "";
            $records[$key]->make            = isset($record->schedule->vehicle->make) ? ($record->schedule->vehicle->make) : "";
            $records[$key]->modal           = isset($record->schedule->vehicle->modal) ? ($record->schedule->vehicle->modal) : "";
            $records[$key]->vacant_seat     = isset($record->schedule->vacant_seat) ? ($record->schedule->vacant_seat) : "";
            $records[$key]->pickup_address  = isset($record->schedule->pickup_address) ? ($record->schedule->pickup_address) : "";
            $records[$key]->dropoff_address = isset($record->schedule->dropoff_address) ? ($record->schedule->dropoff_address) : "";
            $records[$key]->schedule_date   = isset($record->schedule->schedule_date) ? ($record->schedule->schedule_date) : "";
            $records[$key]->start_time      = isset($record->schedule->start_time) ? ($record->schedule->start_time) : "";
            $records[$key]->end_time        = isset($record->schedule->end_time) ? ($record->schedule->end_time) : "";
            $records[$key]->ride_fare       = isset($record->schedule->fare) ? ($record->schedule->fare) : "";
            $records[$key]->status_name     = isset($record->status->name) ? ($record->status->name) : "";
            $records[$key]->ride_distance   = "";
            $records[$key]->comment         = " --- No Comments --- ";
            $records[$key]->capt_rating     = People_rating::where('people_ratings.schedule_id',$record->schedule->id)->avg('people_ratings.rating_stars');
            
            if(isset($records[$key]->schedule) ){
                unset($records[$key]->schedule);
            }

            if(isset($records[$key]->status) ){
                unset($records[$key]->status);
            }
        }


        return $records;

    }

    protected function fetch_bookings_history(Request $request)
    {
        $records     = History::orderBy('histories.created_at')
                        ->select('id', 'people_id','schedule_id','booking_id','detail','status_id', 'type')
                        ->whereNotNull('schedule_id')
                        ->whereNotNull('booking_id')
                        ->where('type', 0)  // type: 0  = Passenger
                        ->where('people_id', $request->people_id)
                        ->where('status_id', 4) // completed 
                        ->get();

        foreach ($records as $key => $record) {
            $records[$key]->cap_name        = isset($record->schedule->captain->fname) ? ($record->schedule->captain->fname) : "";
            $records[$key]->make            = isset($record->schedule->vehicle->make) ? ($record->schedule->vehicle->make) : "";
            $records[$key]->modal           = isset($record->schedule->vehicle->modal) ? ($record->schedule->vehicle->modal) : "";
            $records[$key]->vacant_seat     = isset($record->schedule->vacant_seat) ? ($record->schedule->vacant_seat) : "";
            $records[$key]->pickup_address  = isset($record->schedule->pickup_address) ? ($record->schedule->pickup_address) : "";
            $records[$key]->dropoff_address = isset($record->schedule->dropoff_address) ? ($record->schedule->dropoff_address) : "";
            $records[$key]->schedule_date   = isset($record->schedule->schedule_date) ? ($record->schedule->schedule_date) : "";
            $records[$key]->start_time      = isset($record->schedule->start_time) ? ($record->schedule->start_time) : "";
            $records[$key]->end_time        = isset($record->schedule->end_time) ? ($record->schedule->end_time) : "";
            $records[$key]->ride_fare       = isset($record->schedule->fare) ? ($record->schedule->fare) : "";
            $records[$key]->status_name     = isset($record->status->name) ? ($record->status->name) : "";
            $records[$key]->ride_distance   = "";
            $records[$key]->comment         = " --- No Comments --- ";
            
            if(isset($records[$key]->schedule) ){
                unset($records[$key]->schedule);
            }

            if(isset($records[$key]->status) ){
                unset($records[$key]->status);
            }
        }

        return $records;
    }

    public function fetch_ride_history(MainRequest $request) // done
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "fetch_ride_history")) ){
            return $this->returnResponse("failed","Validation errors",["The action field not matched."], 404);
        }

        $record              = People::where('id', $request->people_id)->first();
        if(($record->type  != "Captain") && ((ucfirst($request->role)) == "Captain") ){
            return $this->returnResponse("failed","Validation errors",["Passenger can't be toggled to captain."], 404);

        }else if(( (ucfirst(strtolower($request->role))) != "Passenger")  && ((ucfirst(strtolower($request->role))) != "Captain")){
            return $this->returnResponse("failed","Validation errors",["Invalid toggle value."], 404);

        }else{
            // BEGIN::update role of people from passenger to captain or vice versa
                $rec['role'] = ((((ucfirst(strtolower($request->role)))) == "Passenger") ? 0 : 1 ); // 1: captain and 0: passenger
                // $record->update($rec);
            // END::update role of people from passenger to captain or vice versa

            $type_flg = "schedules";
            if( $rec['role'] == 1 ){
                $records    = $this->fetch_schedules_history($request);
            }else{
                $type_flg = "bookings";
                $records    = $this->fetch_bookings_history($request);
            }
            
       

            $msg                 = "Role toggled & ".$type_flg." history fetched successfully";
            $status              = "success";
            $code                = 200;
            $data                = ['records' => $records];
           
            return $this->returnResponse("success",$msg,$data, $code);
        }


    }
    
    public function logout()
    {
        $record         = request()->user(); 
        if($record){
            // Revoke current user token
            $record->tokens()->where('id', $record->currentAccessToken()->id)->delete();
            return $this->returnResponse("success","logout successfully.",[], 200);
        }else{
            return $this->returnResponse("failed","Validation errors",["Token not found."], 404);
        }
    }

    private function getaddress($lat,$lng) // not used in system
    {
        $GOOGLE_API_KEY  = "AIzaSyDv_BD3VEJY5prw23hH7G1iaeoNfWdmkDk";

        $url    = "https://maps.google.com/maps/api/geocode/json?key=".$GOOGLE_API_KEY."&latlng=".$lat.",".$lng."&sensor=false";
        $json   = file_get_contents($url);
        $data   = json_decode($json);

        if(($data->status)=="OK")
            return $data->results[0]->formatted_address;
        else
            return null;
    }
}


