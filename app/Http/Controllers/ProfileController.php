<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users  = User::with('profiles')->get();

        return response()->json([
            'users' => $users,
            'message' => 'Users!'
        ], 201);
    }



    public function index2()
    {
        $id = Auth::id();
        $users = User::findOrFail($id);
        $profile = Profile::find($id)->where('users_id', '=', $id)->first();

        return response()->json([
            'users' => $users,
            'profile' => $profile,
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
       // $users = User::find($id);
        //Session::has('id');
        //$users = User::find('id');
        $id = Auth::id();
        $users = User::find($id);
        $profile = new Profile();
            $profile->description = $request->description;
            $profile->photo = $request->file('file')->store('profiles');

        $users->profiles()->save($profile);

        return response()->json([
            'users' => $users,
            'message' => 'Created profile'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile, $id)
    {
        $profile = Profile::find($id);
        if(is_null($profile))
        {
            return response()->json([
                'message' => 'Users Not Found!'
            ], 404);
        }

        return response()->json([
            'profiles' => $profile,
            'message' => 'Users!'
        ], 201);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile, $id)
    {
        $profile = Profile::find($id);
        if($request->file('file'))
        {
           $profile->photo = $request->file('file')->store('prpfiles');
        }
        if(is_null($profile))
        {
            return response()->json([
                'message' => 'Users Not Found!'
            ], 404);
        }
        $profile->update($request->all());
        return response()->json([
            'profile' => $profile,
            'message' => 'Successfully updated user!!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile, $id)
    {
        $profile = DB::table('profiles')->where('id', $id)->first();
        $img = storage_path()."/app/".$profile->photo;

        unlink($img);

        if(is_null($profile))
        {
            return response()->json([
                'message' => 'Users Not Found!'
            ], 404);
        }
        DB::table('profiles')->where('id', $id)->delete();

        return response()->json([
            null,
            'message' => 'User deleted !'
        ], 200);
    }
}
