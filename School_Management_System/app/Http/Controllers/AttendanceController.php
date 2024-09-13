<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\StudentAttendanceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function AttendanceStudent(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date')))
        {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Student Attendance";
        return view('admin/attendance/student',$data);
    }

    public function AttendanceStudentSubmit(Request $request)
    {
        $check_att = StudentAttendanceModel::checkAtt($request->student_id,$request->class_id,$request->attendance_date);

        if(!empty($check_att))
        {
            $att = $check_att;
           
        }
        else
        {
            $att = new StudentAttendanceModel();
            $att->student_id = $request->student_id;
            $att->class_id = $request->class_id;
            $att->attendance_date = $request->attendance_date;
        }

        $att->attendance_type = $request->attendance_type;
        $att->created_by = Auth::user()->id;
        $att->save();

        $json['message'] = "Attendance Successfully Saved";
        echo json_encode($json);
    }

    public function AttendanceReport()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = StudentAttendanceModel::getRecord();
        $data['header_title'] = "Attendance Report";
        return view('admin/attendance/report',$data);
    }

    //Teacher Side
    public function AttendanceStudentTeacher(Request $request)
    {
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date')))
        {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        $data['header_title'] = "Student Attendance";
        return view('ogretmen/attendance/student_teacher',$data);
    }

    public function AttendanceReportTeacher()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = StudentAttendanceModel::getRecord();
        $data['header_title'] = "Attendance Report";
        return view('ogretmen/attendance/report_teacher',$data);
    }
}
