<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::with('posts')->get();
        $posts = Post::select('*')
               // ->join('posts', 'posts.id', '=', 'users.id' )
                ->get();
        //$users = User::with('posts')->get();
        return response()->json([
           // 'users' => $users,
            'posts' => $posts,
            'message' => 'Users!'
        ], 201);
    }

    public function index2()
    {
        $id = Auth::id();
        $users = User::findOrFail($id);
        //$posts = Post::find($id)->where('users_id', '=', $id)->first();
       $posts = DB::table('posts')->where('users_id', '=', $id)->get();
        return response()->json([
            'users' => $users,
            'posts' => $posts,
            'message' => 'Users!'
        ], 201);
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
        $id = Auth::id();
        $users = User::find($id);

        $post = new Post();
            $post->title = $request->title;
            $post->photo = $request->file('file')->store('post');
            $post->description = $request->description;
            $post->address = $request->address;

            $users->posts()->save($post);

        return response()->json([
            'users' => $users,
            'message' => 'Users!'
        ], 201);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $id)
    {
        $post = Post::find($id);
        if(is_null($post))
        {
            return response()->json([
                'message' => 'Users Not Found!'
            ], 404);
        }

        return response()->json([
            'post' => $post,
            'message' => 'Users!'
        ], 201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, $id)
    {
        $post = Post::find($id);
        if($request->file('file'))
        {
            $profile->storage = $request->file('file')->store('post');


        }
        if(is_null($post))
        {
            return response()->json([
                'message' => 'Users Not Found!'
            ], 404);
        }
        $post->update($request->all());
        return response()->json([
            'post' => $post,
            'message' => 'Successfully updated user!!'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, $id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        $img = storage_path()."/app/".$post->photo;

        unlink($img);
        if(is_null($post))
        {
            return response()->json([
                'message' => 'Users Not Found!'
            ], 404);
        }
        DB::table('posts')->where('id', $id)->delete();

        return response()->json([
            null,
            'message' => 'User deleted !'
        ], 200);
    }
}
