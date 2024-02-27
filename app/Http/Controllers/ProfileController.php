<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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



        return redirect('myprofile');
    }
}
