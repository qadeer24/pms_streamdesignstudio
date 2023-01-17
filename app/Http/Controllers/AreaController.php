<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Area;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:area-list', ['only' => ['index','show']]);
         $this->middleware('permission:area-create', ['only' => ['create','store']]);
         $this->middleware('permission:area-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:area-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('areas.index');
    }

    public function list()
    {
        $data   = Area::orderBy('areas.name')
                    ->leftjoin('cities', 'cities.id', '=', 'areas.city_id')
                    ->select(
                                'areas.id',
                                'areas.name',
                                'areas.active',
                                'cities.name as city_name'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="areas/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="areas/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_area') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function create()
    {

        $cities        = City::pluck('name','id')->all();
        return view('areas.create',compact('cities'));
    }

    public function store(AreaRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Area::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data           = Area::findorFail($id);
        $cities         = City::pluck('name','id')->all();


        return view('areas.show',compact(
                                            'data',
                                            'cities'
                                        ));
    }


    public function edit($id)
    {
        $data           = Area::findorFail($id);
        $cities         = City::pluck('name','id')->all();
        return view('areas.edit',compact('data','cities'));
    }


    public function update(AreaRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Area::findOrFail($id);
        $input      = $request->all();

        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // update
        $upd        = $data->update($input);
        return response()->json(['success'=>$request['name']. ' updated successfully.']);
    }

    public function destroy(Request $request)
    {
        $data   = Area::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." City deleted successfully."]);
    }

}
