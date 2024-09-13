<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{

   
    
    public function myAccount()
    {
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = "My Account";

        if(Auth::user()->user_type == 1){
            return view('admin.my_account',$data);
        }
        else if(Auth::user()->user_type == 2){
            return view('ogretmen.my_account',$data);
        }
        else if(Auth::user()->user_type == 3){
            return view('ogrenci.my_account',$data);
        }
        else if(Auth::user()->user_type == 4){
            return view('veli.my_account',$data);
        }
        
    }


    public function AdminUpdateMyAccount(Request $request)
    {
        $id = Auth::user()->id;
          // Form validasyonu
          $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        // Güncellenen kullanıcıyı al
        $user = User::getSingle($id);
        if ($user) {
            $user->name = trim($request->name);
            $user->last_name = trim($request->last_name);
            $user->email = trim($request->email);
            if (!empty($request->password)) {
                $user->password = Hash::make(trim($request->password));
            }
            $user->save();

            return redirect()->back()->with('success', "Your Account Successfully Updated");
        } else {
            abort(404);
        }
    }
    public function updateMyAccount(Request $request){
        $id = Auth::user()->id;
        
        
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $id,
                'mobile_number' => 'max:15|min:10',
                'marital_status' => 'max:50'
            ]);
        
            $teacher = User::getSingle($id);
        
            $teacher->name = trim($request->name);
            $teacher->last_name = trim($request->last_name);
            $teacher->gender = trim($request->gender);
        
            if(!empty($request->date_of_birth)){
                $teacher->date_of_birth = trim($request->date_of_birth);
            }
        
            if(!empty($request->file('profile_pic')))
            {
                $ext = $request->file('profile_pic')->getClientOriginalExtension();
                $file = $request->file('profile_pic');
                $randomStr = date('Ymdhis').Str::random(20);
                $filename = strtolower($randomStr) . '.' . $ext;
                $file->move('upload/profile/', $filename);
        
                $teacher->profile_pic = $filename;
            }
            
            $teacher->mobile_number = trim($request->mobile_number);
        
            
            $teacher->marital_status = trim($request->marital_status);
            $teacher->address = trim($request->address);
            $teacher->perminant_address = trim($request->perminant_address);
            $teacher->qualification = trim($request->qualification);
            $teacher->work_experience = trim($request->work_experience);
            $teacher->email = trim($request->email);
            $teacher->user_type = 2;
            $teacher->save();
        
            return redirect()->back()->with('success', "Your Account Successfully Updated");
        
    }

    public function StudentUpdateMyAccount(Request $request){
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'height' => 'max:10',
            'weight' => 'max:10',
            'blood_group' => 'max:10',
            'mobile_number' => 'max:15|min:10',
            'caste' => 'max:50',
            'religion' => 'max:50',
            
        ]);

        $student = User::getSingle($id);

        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->gender = trim($request->gender);

        if(!empty($request->date_of_birth)){
            $student->date_of_birth = trim($request->date_of_birth);
        }

        if(!empty($request->file('profile_pic')))
        {
            if(!empty($student->getProfile())){
                unlink('upload/profile/' . $student->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);

            $student->profile_pic = $filename;
        }
        
        $student->caste = trim($request->caste);
        $student->religion = trim($request->religion);
        $student->mobile_number = trim($request->mobile_number);


        
        $student->profile_pic = trim($request->profile_pic);
        $student->blood_group = trim($request->blood_group);
        $student->height = trim($request->height);
        $student->weight = trim($request->weight);
        $student->email = trim($request->email);
        $student->save();

        return redirect()->back()->with('success', "Your Account Successfully Updated");
    }

    public function ParentUpdateMyAccount(Request $request){
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15|min:10',
            'address' => 'max:255',
            'occupation' => 'max:255'
         
     ]);
 
     $parent = User::getSingle($id);
     
     $parent->name = trim($request->name);
     $parent->last_name = trim($request->last_name);
     $parent->gender = trim($request->gender);
     $parent->occupation = trim($request->occupation);
     $parent->address = trim($request->address);
 
     if(!empty($request->file('profile_pic')))
     {
         if(!empty($parent->getProfile())){
             unlink('upload/profile/' . $parent->profile_pic);
         }
         $ext = $request->file('profile_pic')->getClientOriginalExtension();
         $file = $request->file('profile_pic');
         $randomStr = date('Ymdhis').Str::random(20);
         $filename = strtolower($randomStr) . '.' . $ext;
         $file->move('upload/profile/', $filename);
 
         $parent->profile_pic = $filename;
     }
 
     
     $parent->mobile_number = trim($request->mobile_number);
     $parent->email = trim($request->email);
     
     $parent->save();
 
     return redirect()->back()->with('success', "Your Account Successfully Updated");
    }

   

    
    
    
    public function change_password(){
        $data['header_title'] = "Change Password";
        return view('profile.change_password');
    }

    public function  update_change_password(Request $request){
        $user = User::getSingle(Auth::user()->id);

        if(Hash::check($request->old_password, $user->password))
        {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Your Password Successfully Changed');
        }
        else
        {
            return redirect()->back()->with('error', 'Old password is not correct');
        }
    }
}
