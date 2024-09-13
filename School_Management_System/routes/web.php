<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OgrenciMiddleware;
use App\Http\Middleware\OgretmenMiddleware;
use App\Http\Middleware\VeliMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\ClassTimeTableController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AttendanceController;


// Account Side
Route::get('/',[AuthController::class, 'login']);
Route::post('login',[AuthController::class, 'AuthLogin']);
Route::get('logout',[AuthController::class, 'logout']);
Route::get('forgot-password',[AuthController::class, 'forgotpassword']);
Route::post('forgot-password',[AuthController::class, 'postForgotpassword']);
Route::get('reset/{token}',[AuthController::class, 'reset']);
Route::post('reset/{token}',[AuthController::class, 'PostReset']);





//Admin URL's
Route::group(['middleware' => 'admin'], function(){

    Route::get('admin/dashboard',[DashboardController::class, 'dashboard'])->middleware(AdminMiddleware::class);
    route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add',[AdminController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/admin/add',[AdminController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/admin/edit/{id}',[AdminController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/admin/edit/{id}',[AdminController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/admin/delete/{id}',[AdminController::class, 'delete'])->middleware(AdminMiddleware::class);

    
    //Admin Class route
    route::get('admin/class/list', [ClassController::class, 'list'])->middleware(AdminMiddleware::class);
    Route::get('admin/class/add',[ClassController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/class/add',[ClassController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/class/edit/{id}',[ClassController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/class/edit/{id}',[ClassController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/class/delete/{id}',[ClassController::class, 'delete'])->middleware(AdminMiddleware::class);

    //Admin Subject route
    route::get('admin/subject/list', [SubjectController::class, 'list'])->middleware(AdminMiddleware::class);
    Route::get('admin/subject/add',[SubjectController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/subject/add',[SubjectController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/subject/edit/{id}',[SubjectController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/subject/edit/{id}',[SubjectController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/subject/delete/{id}',[SubjectController::class, 'delete'])->middleware(AdminMiddleware::class);

    //Admin Assign Subject route
    route::get('admin/assign_subject/list', [ClassSubjectController::class, 'list'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_subject/add',[ClassSubjectController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/assign_subject/add',[ClassSubjectController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_subject/edit/{id}',[ClassSubjectController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/assign_subject/edit/{id}',[ClassSubjectController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_subject/delete/{id}',[ClassSubjectController::class, 'delete'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_subject/edit_single/{id}',[ClassSubjectController::class, 'edit_single'])->middleware(AdminMiddleware::class);
    Route::post('admin/assign_subject/edit_single/{id}',[ClassSubjectController::class, 'update_single'])->middleware(AdminMiddleware::class);


    //Admin Assign Class Teacher route
    route::get('admin/assign_class_teacher/list', [AssignClassTeacherController::class, 'list'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_class_teacher/add',[AssignClassTeacherController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/assign_class_teacher/add',[AssignClassTeacherController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_class_teacher/edit/{id}',[AssignClassTeacherController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/assign_class_teacher/edit/{id}',[AssignClassTeacherController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_class_teacher/delete/{id}',[AssignClassTeacherController::class, 'delete'])->middleware(AdminMiddleware::class);
    Route::get('admin/assign_class_teacher/edit_single/{id}',[AssignClassTeacherController::class, 'edit_single'])->middleware(AdminMiddleware::class);
    Route::post('admin/assign_class_teacher/edit_single/{id}',[AssignClassTeacherController::class, 'update_single'])->middleware(AdminMiddleware::class);


    //Admin Change Password route
    Route::get('admin/change_password',[UserController::class, 'change_password'])->middleware(AdminMiddleware::class);
    Route::post('admin/change_password',[UserController::class, 'update_change_password'])->middleware(AdminMiddleware::class);

    //Admin Teacher route
    route::get('admin/teacher/list', [TeacherController::class, 'list'])->middleware(AdminMiddleware::class);
    Route::get('admin/teacher/add',[TeacherController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/teacher/add',[TeacherController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/teacher/edit/{id}',[TeacherController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/teacher/edit/{id}',[TeacherController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/teacher/delete/{id}',[TeacherController::class, 'delete'])->middleware(AdminMiddleware::class);

    //Admin Student route
    route::get('admin/student/list', [StudentController::class, 'list'])->middleware(AdminMiddleware::class);
    Route::get('admin/student/add',[StudentController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/student/add',[StudentController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/student/edit/{id}',[StudentController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/student/edit/{id}',[StudentController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/student/delete/{id}',[StudentController::class, 'delete'])->middleware(AdminMiddleware::class);


    //Admin Parents route
    route::get('admin/parent/list', [ParentController::class, 'list'])->middleware(AdminMiddleware::class);
    Route::get('admin/parent/add',[ParentController::class, 'add'])->middleware(AdminMiddleware::class);
    Route::post('admin/parent/add',[ParentController::class, 'insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/parent/edit/{id}',[ParentController::class, 'edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/parent/edit/{id}',[ParentController::class, 'update'])->middleware(AdminMiddleware::class);
    Route::get('admin/parent/delete/{id}',[ParentController::class, 'delete'])->middleware(AdminMiddleware::class);
    Route::get('admin/parent/parents_student/{id}',[ParentController::class, 'parentsStudent'])->middleware(AdminMiddleware::class);
    Route::get('admin/parent/assign_student_parent/{student_id}/{parent_id}',[ParentController::class, 'assignStudentParent'])->middleware(AdminMiddleware::class);
    Route::get('admin/parent/assign_student_parent_delete/{student_id}',[ParentController::class, 'assignStudentParentDelete'])->middleware(AdminMiddleware::class);

    Route::get('admin/my_account',[UserController::class, 'myAccount'])->middleware(AdminMiddleware::class);
    Route::post('admin/my_account',[UserController::class, 'AdminUpdateMyAccount'])->middleware(AdminMiddleware::class);

    //Admin Class Time Table route

    route::get('admin/class_timetable/list', [ClassTimeTableController::class, 'list'])->middleware(AdminMiddleware::class);
    route::post('admin/class_timetable/get_subject', [ClassTimeTableController::class, 'get_subject'])->middleware(AdminMiddleware::class);
    route::post('admin/class_timetable/add', [ClassTimeTableController::class, 'insert_update'])->middleware(AdminMiddleware::class);

    //Admin Examination route
    route::get('admin/examinations/exam/list', [ExaminationsController::class, 'exam_list'])->middleware(AdminMiddleware::class);
    Route::get('admin/examinations/exam/add',[ExaminationsController::class, 'exam_add'])->middleware(AdminMiddleware::class);
    Route::post('admin/examinations/exam/add',[ExaminationsController::class, 'exam_insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/examinations/exam/edit/{id}',[ExaminationsController::class, 'exam_edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/examinations/exam/edit/{id}',[ExaminationsController::class, 'exam_update'])->middleware(AdminMiddleware::class);
    Route::get('admin/examinations/exam/delete/{id}',[ExaminationsController::class, 'exam_delete'])->middleware(AdminMiddleware::class);


    //Exam Marks Register route
    Route::get('admin/examinations/exam_marks_register',[ExaminationsController::class, 'exam_marks'])->middleware(AdminMiddleware::class);
    Route::post('admin/examinations/submit_marks_register',[ExaminationsController::class, 'submit_marks_register'])->middleware(AdminMiddleware::class);
    Route::post('admin/examinations/submit_single_marks_register',[ExaminationsController::class, 'submit_single_marks_register'])->middleware(AdminMiddleware::class);

    //Mark Grade route
    Route::get('admin/examinations/mark_grade/list', [ExaminationsController::class, 'mark_grade_admin'])->middleware(AdminMiddleware::class);
    Route::get('admin/examinations/mark_grade/add',[ExaminationsController::class, 'mark_grade_add'])->middleware(AdminMiddleware::class);
    Route::post('admin/examinations/mark_grade/add',[ExaminationsController::class, 'mark_grade_insert'])->middleware(AdminMiddleware::class);
    Route::get('admin/examinations/mark_grade/edit/{id}',[ExaminationsController::class, 'mark_grade_edit'])->middleware(AdminMiddleware::class);
    Route::post('admin/examinations/mark_grade/edit/{id}',[ExaminationsController::class, 'mark_grade_update'])->middleware(AdminMiddleware::class);
    Route::get('admin/examinations/mark_grade/delete/{id}',[ExaminationsController::class, 'mark_grade_delete'])->middleware(AdminMiddleware::class);

    

    //Admin Exam Schedule route
    Route::get('admin/examinations/exam_schedule',[ExaminationsController::class, 'ExamSchedule'])->middleware(AdminMiddleware::class);
    Route::post('admin/examinations/exam_schedule_insert',[ExaminationsController::class, 'ExamScheduleInsert'])->middleware(AdminMiddleware::class);


    //Admin Student Attendance route
    Route::get('admin/attendance/student',[AttendanceController::class, 'AttendanceStudent'])->middleware(AdminMiddleware::class);
    Route::post('admin/attendance/student/save',[AttendanceController::class, 'AttendanceStudentSubmit'])->middleware(AdminMiddleware::class);
    Route::get('admin/attendance/report',[AttendanceController::class, 'AttendanceReport'])->middleware(AdminMiddleware::class);


});


//Ogretmen URL's
Route::group(['middleware' => 'ogretmen'], function(){

    Route::get('ogretmen/dashboard',[DashboardController::class, 'dashboard'])->middleware(OgretmenMiddleware::class);

    //Teacher Class Subject route
    Route::get('ogretmen/my_class_subject',[AssignClassTeacherController::class, 'MyClassSubject'])->middleware(OgretmenMiddleware::class);

    //Teacher Student route
    Route::get('ogretmen/my_student',[StudentController::class, 'MyStudent'])->middleware(OgretmenMiddleware::class);
    
    //Time Table route
    Route::get('ogretmen/my_class_subject/class_timetable/{class_id}/{subject_id}',[ClassTimeTableController::class, 'MyTimetableTeacher'])->middleware(OgretmenMiddleware::class);
 
    //Exam Timetable route
    Route::get('ogretmen/exam_timetable',[ExaminationsController::class, 'ExamTimetable'])->middleware(OgretmenMiddleware::class);

    //Calendar route
    Route::get('ogretmen/teacher_calendar',[CalendarController::class, 'TeacherCalendar'])->middleware(OgretmenMiddleware::class);

    //Teacher Account route
    Route::get('ogretmen/my_account',[UserController::class, 'myAccount'])->middleware(OgretmenMiddleware::class);
    Route::post('ogretmen/my_account',[UserController::class, 'updateMyAccount'])->middleware(OgretmenMiddleware::class);

    //Change Password route
    Route::get('ogretmen/change_password',[UserController::class, 'change_password'])->middleware(OgretmenMiddleware::class);
    Route::post('ogretmen/change_password',[UserController::class, 'update_change_password'])->middleware(OgretmenMiddleware::class);

    //Marks register route
    Route::get('ogretmen/register_mark',[ExaminationsController::class, 'register_mark_teacher'])->middleware(OgretmenMiddleware::class);
    Route::post('ogretmen/submit_marks_register',[ExaminationsController::class, 'submit_marks_register'])->middleware(OgretmenMiddleware::class);
    Route::post('ogretmen/submit_single_marks_register',[ExaminationsController::class, 'submit_single_marks_register'])->middleware(OgretmenMiddleware::class);

    //Attendance route
    Route::get('ogretmen/attendance/student_teacher',[AttendanceController::class, 'AttendanceStudentTeacher'])->middleware(OgretmenMiddleware::class);
    Route::post('ogretmen/attendance/student_teacher/save',[AttendanceController::class, 'AttendanceStudentSubmit'])->middleware(OgretmenMiddleware::class);
    Route::get('ogretmen/attendance/report_teacher',[AttendanceController::class, 'AttendanceReportTeacher'])->middleware(OgretmenMiddleware::class);
});


//ogrenci URL's
Route::group(['middleware' => 'ogrenci'], function(){

    Route::get('ogrenci/dashboard',[DashboardController::class, 'dashboard'])->middleware(OgrenciMiddleware::class);

    //Student Subject route
    Route::get('ogrenci/my_subject',[SubjectController::class, 'MySubject'])->middleware(OgrenciMiddleware::class);

    //Student Timetable route
    Route::get('ogrenci/my_timetable',[ClassTimeTableController::class, 'MyTimetable'])->middleware(OgrenciMiddleware::class);
    Route::get('ogrenci/my_exam_timetable',[ExaminationsController::class, 'MyExamTimetable'])->middleware(OgrenciMiddleware::class);

    //Calendar route
    Route::get('ogrenci/my_calendar',[CalendarController::class, 'MyCalendar'])->middleware(OgrenciMiddleware::class);

    //Student Account route
    Route::get('ogrenci/my_account',[UserController::class, 'myAccount'])->middleware(OgrenciMiddleware::class);
    Route::post('ogrenci/my_account',[UserController::class, 'StudentUpdateMyAccount'])->middleware(OgrenciMiddleware::class);

    //Change Password route
    Route::get('ogrenci/change_password',[UserController::class, 'change_password'])->middleware(OgrenciMiddleware::class);
    Route::post('ogrenci/change_password',[UserController::class, 'update_change_password'])->middleware(OgrenciMiddleware::class);

    //Exam Marks route
    Route::get('ogrenci/register_mark',[ExaminationsController::class, 'my_exam_result'])->middleware(OgrenciMiddleware::class);
});


//Veli URL's
Route::group(['middleware' => 'veli'], function(){

    Route::get('veli/dashboard',[DashboardController::class, 'dashboard'])->middleware(VeliMiddleware::class);

    Route::get('veli/my_account',[UserController::class, 'myAccount'])->middleware(VeliMiddleware::class);
    Route::post('veli/my_account',[UserController::class, 'ParentUpdateMyAccount'])->middleware(VeliMiddleware::class);

    Route::get('veli/my_student',[ParentController::class, 'MyStudent'])->middleware(VeliMiddleware::class);

     //Time Table
     Route::get('veli/my_student/subject/class_timetable/{class_id}/{subject_id}/{student_id}',[ClassTimeTableController::class, 'MyTimetableParent'])->middleware(VeliMiddleware::class);

     //Exam Timetable
     Route::get('veli/my_student/exam_timetable/{student_id}',[ExaminationsController::class, 'ExamTimetableParent'])->middleware(VeliMiddleware::class);

     //Calendar route
     Route::get('veli/my_student/calendar/{student_id}',[CalendarController::class, 'MyStudentCalendar'])->middleware(VeliMiddleware::class);

     //Subject route
     Route::get('veli/my_student/subject/{student_id}',[SubjectController::class, 'ParentStudentSubject'])->middleware(VeliMiddleware::class);

     //Exam Result route
     Route::get('veli/my_student/exam_result/{student_id}',[ExaminationsController::class, 'MyStudentExamResults'])->middleware(VeliMiddleware::class);
    

     //Change Password url
     Route::get('veli/change_password',[UserController::class, 'change_password'])->middleware(VeliMiddleware::class);
     Route::post('veli/change_password',[UserController::class, 'update_change_password'])->middleware(VeliMiddleware::class);
});







