<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $data['header_title'] = 'Dashboard';
        if(Auth::user()->user_type == 1){
            return view('admin.dashboard', $data);
        }
        else if(Auth::user()->user_type == 2){
            return view('ogretmen.dashboard',$data);
        }
        else if(Auth::user()->user_type == 3){
            return view('ogrenci.dashboard',$data);
        }
        else if(Auth::user()->user_type == 4){
            return view('veli.dashboard',$data);
        }
    }
}
