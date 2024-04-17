<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrameWork;

class FrameWorkController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:frameworks-list', ['only' => ['index','show']]);
         $this->middleware('permission:frameworks-create', ['only' => ['create','store']]);
         $this->middleware('permission:frameworks-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:frameworks-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $frameworks = FrameWork::all();
        return view('frameworks.index',compact('frameworks'));
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|max:255|unique:frame_works',
        ]);

        $framework = FrameWork::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        if ($framework) {
            return response()->json(['success'=>$request->name. ' added successfully.']);
        }else{
            return response()->json(['error'=>'Failed to add framework']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|max:255|unique:frame_works,name,'.$request->framework_id,
        ]);

        $framework = FrameWork::where('id',$request->framework_id)->firstOrFail();
        $framework->name = $request->name;
        $framework->description = $request->description;
        $framework->save();
        if ($framework) {
            return response()->json(['success'=>$request->name. ' updated successfully.']);
        }else{
            return response()->json(['error'=>'Failed to update framework']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrameWork $framework)
    {
        $framework->delete();

        return redirect()->route('frameworks.index')->with('success_message', 'Framework deleted successfully');
    }
}
