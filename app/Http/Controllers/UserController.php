<?php

namespace App\Http\Controllers;
use App;
use config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function getDashboard()
    {
        return view('dashboard');
    }
    public function postSignUp(Request $request)
    {
        //validation code
        $this->validate($request, [
            //email from the form, unique from the table users
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|min:8'

        ]);


        $email = $request['email'];
        $first_name = $request['first_name'];
        $password = bcrypt($request['password']);

        $user = new App\User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;

        $user->save();
        return redirect()->route('dashboard');
    }
    public function postSignIn(Request $request)
    {
        if( Auth::attempt(['email'=>$request['email'], 'password'=>$request['password']]))//true or false
        {
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }
}
