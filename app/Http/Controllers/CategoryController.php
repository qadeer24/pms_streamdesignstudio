<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:categories-list', ['only' => ['index','show']]);
         $this->middleware('permission:categories-create', ['only' => ['create','store']]);
         $this->middleware('permission:categories-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:categories-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Category::all();
        return view('categories.index',compact('categories'));
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
            'name' => 'required|string|min:2|max:255|unique:categories',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::user()->id
        ]);
        if ($category) {
            return response()->json(['success'=>$request->name. ' added successfully.']);
        }else{
            return response()->json(['error'=>'Failed to add category']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|max:255',
        ]);

        $category = Category::where('id',$request->cat_id)->firstOrFail();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        if ($category) {
            return response()->json(['success'=>$request->name. ' updated successfully.']);
        }else{
            return response()->json(['error'=>'Failed to update category']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success_message', 'Category deleted successfully');
    }
}
