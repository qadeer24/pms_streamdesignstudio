<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Auth;

class CommentController extends Controller
{
    function __construct()
    {
         // $this->middleware('permission:comments-list', ['only' => ['index','show']]);
         // $this->middleware('permission:comments-create', ['only' => ['create','store']]);
         // $this->middleware('permission:comments-edit', ['only' => ['edit','update']]);
         // $this->middleware('permission:comments-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
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
        if (empty($request->comment) && empty($request->comment_file)) {
            return response()->json(['error' => 'Invalid comment value'], 500);
        }

        $new_name = null;
        if($request->has('comment_file')){
            $image = $request->file('comment_file');
            $new_name = $image->getClientOriginalName();
            $image->move(public_path("uploads/comments"), $new_name);
        }

        $comment = Comment::create([
            'project_id'    => $request->project_id,
            'comment'       => $request->comment,
            'comment_file'  => $new_name,
            'comment_by'    => Auth::user()->id
        ]);

        return response()->json(['success' => 'Comment posted successfully', 'comment_file' => $new_name, 'profile_pic' => Auth::user()->profile_pic]);
    }

    protected function getMimeType($filename) {
        return File::mimeType($filename);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    public function fetchNewComments($timestamp)
    {
        $newComments = Comment::where('created_at', '>', $timestamp)->get();
        return response()->json($newComments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
