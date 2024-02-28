<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('myprofile');
    }

    public function editProfile(Request $request)
    {


        $userID = Auth::user()->id;

        $user = User::find($userID);

        $user->fill(['name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'dob' => $request->input('dob'),
        'address' => $request->input('address')]);

        $user->save();

        Session::flash('alert1');

        return redirect('myprofile');
    }

    public function resetPassword(Request $request){
        $userID = Auth::user()->id;

        $user = User::find($userID);

        $hashedPassword = Hash::make($request->input('confirmedPassword'));

        $user->fill(['password' => $hashedPassword]);

        $user->save();

        Session::flash('alert');

        return redirect('myprofile');
    }

    public function editProfile(Request $request){
    // $validateData = $request->validate([
    //     'name' => 'required',
    //     'email' => 'required',
    //     'phone' => 'required',
    //     'dob' => 'required',
    //     'address' => 'required',
    // ]);
    $userID = Auth::user()->id;

    $user = User::find($userID);

    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone = $request->input('phone');
    $user->dob = $request->input('dob');
    $user->address = $request->input('address');

    $user->save();

    return response()->json(['message' => 'Profile Edit successfull!']);
    }
}
