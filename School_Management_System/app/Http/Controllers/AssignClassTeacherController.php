<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\AssignClassTeacherModel;
use Illuminate\Support\Facades\Auth;

class AssignClassTeacherController extends Controller
{
    public function list()
    {
        
        $data['getRecord'] = AssignClassTeacherModel::getRecord();
        $data['header_title'] = "Assign Class Teacher";
        return view('admin.assign_class_teacher.list', $data);
    }

    public function add(Request $request){
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        $data['header_title'] = 'Add Assign Subject';
        return view('admin.assign_class_teacher.add', $data);
    }

    public function insert(Request $request){
        if(!empty($request->teacher_id)){

            foreach($request->teacher_id as $teacher_id){

                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);

                if(!empty( $getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
                else
                {
                    $save = new AssignClassTeacherModel();
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
                
            }
            return redirect('admin/assign_class_teacher/list')->with('success', "Class Successfully Assigned to Teacher");

        }
        else{
            return redirect()->back()->with('error', 'Due to error please try again');
        }
    }

    public function edit($id){
        $getRecord = AssignClassTeacherModel::getSingle($id); 
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getAssignedTeacherID'] = AssignClassTeacherModel::getAssignedTeacherID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = 'Edit Assign Class Teacher';
            return view('admin.assign_class_teacher.edit', $data);
        }
        else{
            abort(404);
        }
        
    }

    public function update(Request $request){
        AssignClassTeacherModel::deleteTeacher($request->class_id);
        if(!empty($request->teacher_id)){

            foreach($request->teacher_id as $teacher_id){

                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);

                if(!empty( $getAlreadyFirst))
                {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                }
                else
                {
                    $save = new AssignClassTeacherModel();
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
                
            }
            
        }
        return redirect('admin/assign_class_teacher/list')->with('success', "Class Teacher Successfully Updated");
    }

    public function delete($id){
        $save = AssignClassTeacherModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Record successfully deleted");
    }

    public function edit_single($id){
        $getRecord = AssignClassTeacherModel::getSingle($id); 
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = 'Edit Assign Class Teacher';
            return view('admin.assign_class_teacher.edit_single', $data);
        }
        else{
            abort(404);
        }
    }

    public function update_single($id, Request $request){
       
        $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $request->teacher_id);
        if(!empty( $getAlreadyFirst))
        {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();
            return redirect('admin/assign_class_teacher/list')->with('success', "Status Successfully Updated");
        }
        else
        {
            $save = AssignClassTeacherModel::getSingle($id);
            $save->class_id = $request->class_id;
            $save->teacher_id = $request->teacher_id;
            $save->status = $request->status;
            $save->save();
            return redirect('admin/assign_class_teacher/list')->with('success', "Class Teacher Successfully Updated");
        }
    }

    public function MyClassSubject(){

        $data['getRecord'] = AssignClassTeacherModel::getMyClassSubject(Auth::user()->id);
        $data['header_title'] = "My Class & Subject";
        return view('ogretmen/my_class_subject',$data);
    }


}