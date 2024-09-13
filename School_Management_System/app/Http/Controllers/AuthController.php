<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(){
        //dd(Hash::make(1234));
        if(!empty(Auth::check())){
            if(Auth::user()->user_type == 1){
                return redirect('admin/dashboard');
            }
            else if(Auth::user()->user_type == 2){
                return redirect('ogretmen/dashboard');
            }
            else if(Auth::user()->user_type == 3){
                return redirect('ogrenci/dashboard');
            }
            else if(Auth::user()->user_type == 4){
                return redirect('veli/dashboard');
            }
        }
        return view('auth.login');
    }

    public function AuthLogin(Request $request){
        $remember = !empty($request->remember) ? true : false;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember)){
            if(Auth::user()->user_type == 1){
                return redirect('admin/dashboard');
            }
            else if(Auth::user()->user_type == 2){
                return redirect('ogretmen/dashboard');
            }
            else if(Auth::user()->user_type == 3){
                return redirect('ogrenci/dashboard');
            }
            else if(Auth::user()->user_type == 4){
                return redirect('veli/dashboard');
            }
            

        }else{
            return redirect()->back()->with('error', 'Please enter correct email and password');
        }

    }

    public function forgotpassword(){
        return view('auth.forgot');
    }

    public function postForgotpassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);

        if(!empty($user)){
            $user->remember_token = Str::random(60);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', 'Please check your email and reset your password');
        }else{
            return redirect()->back()->with('error', 'Email not found');
        }
    }

    public function reset($remember_token){

        $user = User::getTokenSingle($remember_token);

        if(!empty($user)){
            $data['user'] = $user;
            return view('auth.reset', $data);

        }else{
            abort(404);
        }

    }

    public function PostReset($token, Request $request){
        if($request->password == $request->cpassword){
            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(60);
            $user->save();

            return redirect(url(''))->with('success', 'Password successfully reset');
        }else{
            return redirect()->back()->with('error', 'Password and Confirm Password does not match');
        }
    }
    

    public function logout(){
        Auth::logout();
        return redirect(url(''));
    }
}
