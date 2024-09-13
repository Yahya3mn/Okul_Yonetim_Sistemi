<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use Illuminate\Http\Request;
use App\Models\ExamModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamScheduleModel;
use App\Models\User;
use App\Models\MarkRegisterModel;
use App\Models\MarkGradeModel;
use Illuminate\Support\Facades\Auth;

class ExaminationsController extends Controller
{
    public function exam_list(){
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = "Exam List";
        return view('admin.examinations.exam.list',$data);
    }

    public function exam_add()
    {
        $data['header_title'] = "Add New Exam";
        return view('admin.examinations.exam.add', $data);
    }

    public function exam_insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $exam = new ExamModel();
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = Auth::user()->id;
        $exam->save();

        return redirect('admin/examinations/exam/list')->with('success', "Exam successfully added");
    }

    public function exam_edit($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);

        if(!empty($data['getRecord']))
        {
             $data['header_title'] = "Edit Exam";
            return view('admin.examinations.exam.edit', $data);
        }
        else
        {
            abort(404);
        }
       
    }

    public function exam_update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $exam = ExamModel::getSingle($id);
        if ($exam) {
            $exam->name = trim($request->name);
            $exam->note = trim($request->note);
            $exam->save();

            return redirect('admin/examinations/exam/list')->with('success', "Exam successfully updated");
        } else {
            abort(404);
        }
    }

    public function exam_delete($id)
    {
        $getRecord = ExamModel::getSingle($id);
        if ($getRecord) {
            $getRecord->is_delete = 1;
            $getRecord->save();

            return redirect('admin/examinations/exam/list')->with('success', "Exam successfully deleted");
        } else {
            abort(404);
        }
    }

    public function ExamSchedule(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        $result = array();
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $getSubject = ClassSubjectModel::mySubject($request->get('class_id'));
            foreach($getSubject as $value){

                $dataS = array();
                $dataS['subject_id'] = $value->subject_id;
                $dataS['class_id'] = $value->class_id;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_type'] = $value->subject_type;

                $examSchedule = ExamScheduleModel::getRecordSingle($request->get('exam_id'),$request->get('class_id'),$value->subject_id);
                if(!empty($examSchedule))
                {
                    $dataS['exam_date'] = $examSchedule->exam_date;
                    $dataS['start_time'] = $examSchedule->start_time;
                    $dataS['end_time'] = $examSchedule->end_time;
                    $dataS['room_number'] = $examSchedule->room_number;
                    $dataS['full_marks'] = $examSchedule->full_marks;
                    $dataS['passing_marks'] = $examSchedule->passing_marks;
                }
                else
                {
                    $dataS['exam_date'] = '';
                    $dataS['start_time'] = '';
                    $dataS['end_time'] = '';
                    $dataS['room_number'] = '';
                    $dataS['full_marks'] = '';
                    $dataS['passing_marks'] = '';
                }
                $result[] = $dataS;
            }
        }

        $data['getRecord'] = $result;
        $data['header_title'] = "Exam Schedule";
        return view('admin.examinations.exam_schedule', $data);
    }

    public function ExamScheduleInsert(Request $request)
    {
        ExamScheduleModel::deleteRecord($request->exam_id,$request->class_id);
        if(!empty($request->schedule))
        {
            foreach ($request->schedule as $schedule) {
                if(!empty($schedule['subject_id']) && !empty($schedule['exam_date']) && !empty($schedule['start_time']) && !empty($schedule['end_time'])
                && !empty($schedule['room_number']) && !empty($schedule['full_marks']) && !empty($schedule['passing_marks']))
            {
                $exam = new ExamScheduleModel();
                $exam->exam_id = $request->exam_id;
                $exam->class_id = $request->class_id;
                $exam->subject_id = $schedule['subject_id'];
                $exam->exam_date = $schedule['exam_date'];
                $exam->start_time = $schedule['start_time'];
                $exam->end_time = $schedule['end_time'];
                $exam->room_number = $schedule['room_number'];
                $exam->full_marks = $schedule['full_marks'];
                $exam->passing_marks = $schedule['passing_marks'];
                $exam->created_by = Auth::user()->id;
                $exam->save();
            }
            }
        }
        return redirect()->back()->with('success', "Exam successfully Add in Schedule");
    }

    //Mark Grade Admin Side
    public function mark_grade_admin()
    {
        $data['getRecord'] = MarkGradeModel::getRecord();
        $data['header_title'] = "Mark Grade";
        return view('admin.examinations.mark_grade.list',$data);
    }

    public function mark_grade_add()
    {
        $data['header_title'] = "Add New Grade";
        return view('admin.examinations.mark_grade.add',$data);
    }

    public function mark_grade_insert(Request $request)
    {
        $mark = new MarkGradeModel();
        $mark->name = trim($request->name);
        $mark->percent_from = trim($request->percent_from);
        $mark->percent_to = trim($request->percent_to);
        $mark->created_by = Auth::user()->id;
        $mark->save();

        return redirect('admin/examinations/mark_grade/list')->with('success',"Grade Successfully Added");
    }

    public function mark_grade_edit($id)
    {
        $data['getRecord'] = MarkGradeModel::getSingle($id);
        $data['header_title'] = "Edit Grade";
        return view('admin.examinations.mark_grade.edit',$data);
    }

    public function mark_grade_update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $grade = MarkGradeModel::getSingle($id);
        if(!empty($grade))
        {
            $grade->name = trim($request->name);
            $grade->percent_from = trim($request->percent_from);
            $grade->percent_to = trim($request->percent_to);
            $grade->save();

            return redirect('admin/examinations/mark_grade/list')->with('success', "Grade successfully updated");
        }
        else
        {
            abort(404);
        }
    }

    public function mark_grade_delete($id)
    {
        $getRecord = MarkGradeModel::getSingle($id);

        if(!empty($getRecord))
        {
            $getRecord->is_delete = 1;
            $getRecord->save();
            return redirect('admin/examinations/mark_grade/list')->with('success', "Grade successfully deleted");
        }
        else{
            abort(404);
        }
    }

    //Student Side
    public function MyExamTimetable(Request $request)
    {
        $class_id = Auth::user()->class_id;
        $getExamID = ExamScheduleModel::getExamID($class_id);

        $result = array();
        foreach ($getExamID as $value) {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id,$class_id);
            $resultS = array();
            foreach ($getExamTimetable as $valueS) {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_marks'] = $valueS->passing_marks;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = "My Exam Timetable";
        return view('ogrenci.my_exam_timetable',$data);
    }

    //Teacher Side
    public function ExamTimetable(Request $request)
    {
     
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        $result = array();
       foreach ($getClass as $class) {
            $dataC = array();
            $dataC['class_name'] = $class->class_name;
            $getExam = ExamScheduleModel::getExamID($class->class_id);
            $examArray = array();
            foreach ($getExam as $exam) {
                $dataE = array();
                $dataE['exam_name'] = $exam->exam_name;

                $getExamTimetable = ExamScheduleModel::getExamTimetable($exam->exam_id, $class->class_id);
                $subjectArray = array();
                foreach ($getExamTimetable as $valueS) {
                    $dataS = array();
                    $dataS['subject_name'] = $valueS->subject_name;
                    $dataS['exam_date'] = $valueS->exam_date;
                    $dataS['start_time'] = $valueS->start_time;
                    $dataS['end_time'] = $valueS->end_time;
                    $dataS['room_number'] = $valueS->room_number;
                    $dataS['full_marks'] = $valueS->full_marks;
                    $dataS['passing_marks'] = $valueS->passing_marks;
                    $subjectArray[] = $dataS;
                }
                $dataE['subject'] = $subjectArray;
                $examArray[] = $dataE;
            }
            $dataC['exam'] = $examArray;
            $result[] = $dataC;
       }

        $data['getRecord'] = $result;
        $data['header_title'] = "Exam Timetable";
        return view('ogretmen.exam_timetable',$data);
    }

    public function ExamTimetableParent($student_id)
    {
        $getStudent = User::getSingle($student_id);
        $class_id = $getStudent->class_id;
        $getExamID = ExamScheduleModel::getExamID($class_id);

        $result = array();
        foreach ($getExamID as $value) {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id,$class_id);
            $resultS = array();
            foreach ($getExamTimetable as $valueS) {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_marks'] = $valueS->passing_marks;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = "Exam Timetable";
        return view('veli.exam_timetable',$data);
    }

    public function exam_marks(Request $request)
    {

        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $data['getSubject'] = ExamScheduleModel::getExamTimetable($request->get('exam_id'),$request->get('class_id'));
            $data['getStudentClass'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Exam Marks Register";
        return view('admin.examinations.exam_marks_register',$data);
    }

    public function submit_marks_register(Request $request)
    {
        $validation = 0;
        if(!empty($request->mark))
        {
            foreach($request->mark as $mark)
            {
                $getExamSchedule = ExamScheduleModel::getSingle($mark['id']);
                $full_marks = $getExamSchedule->full_marks;
                $class_work = !empty($mark['class_work']) ? $mark['class_work'] : 0;
                $home_work = !empty($mark['home_work']) ? $mark['home_work'] : 0;
                $exam_mark = !empty($mark['exam_mark']) ? $mark['exam_mark'] : 0;
                $full_marks = !empty($mark['full_marks']) ? $mark['full_marks'] : 0;
                $passing_marks = !empty($mark['passing_marks']) ? $mark['passing_marks'] : 0;

                $totalMarks = $class_work * 0.2 + $home_work * 0.2 + $exam_mark * 0.6;

                if($full_marks >= $totalMarks)
                {
                    $getMark = MarkRegisterModel::CheckAlreadyMark($request->student_id,$request->class_id,$request->exam_id,$mark['subject_id']);
                    if(!empty($getMark)){
                        $save = $getMark;
                    }
                    else
                    {
                        $save = new MarkRegisterModel();
                        $save->created_by = Auth::user()->id;
                    }
                    
                    $save->student_id = $request->student_id;
                    $save->class_id = $request->class_id;
                    $save->exam_id = $request->exam_id;
                    $save->subject_id = $mark['subject_id'];
                    $save->class_work =  $class_work;
                    $save->home_work =  $home_work;
                    $save->exam_mark = $exam_mark;
                    $save->full_marks = $full_marks;
                    $save->passing_marks = $passing_marks;
                    $save->save();
                }
                else
                {
                    $validation = 1;
                }
               
            }
        }
        if($validation == 0)
        {
            $json['message'] = "Marks Successfully Saved";
        }
        else
        {
            $json['message'] = "Total Marks Should Not Exceed Full Marks";
        }

        
        echo json_encode($json);
    }

    public function submit_single_marks_register(Request $request)
    {

        $id = $request->id;
        $getExamSchedule = ExamScheduleModel::getSingle($id);
        $full_marks = $getExamSchedule->full_marks;
        $class_work = !empty($request->class_work) ? $request->class_work : 0;
        $home_work = !empty($request->home_work) ? $request->home_work : 0;
        $exam_mark = !empty($request->exam_mark) ? $request->exam_mark : 0;
        

        $totalMarks = $class_work * 0.2 + $home_work * 0.2 + $exam_mark * 0.6;
        if($full_marks >= $totalMarks)
        {
            $getMark = MarkRegisterModel::CheckAlreadyMark($request->student_id,$request->class_id,$request->exam_id,$request->subject_id);
             if(!empty($getMark)){
                 $save = $getMark;
             }
            else
            {
                $save = new MarkRegisterModel();
                $save->created_by = Auth::user()->id;
            }
        
            $save->student_id = $request->student_id;
            $save->class_id = $request->class_id;
            $save->exam_id = $request->exam_id;
            $save->subject_id = $request->subject_id;
            $save->class_work =  $class_work;
            $save->home_work =  $home_work;
            $save->exam_mark = $exam_mark;
            $save->full_marks = $getExamSchedule->full_marks;
            $save->passing_marks = $getExamSchedule->passing_marks;
            $save->save();
       
            $json['message'] = "Marks Successfully Saved";
        }
        else
        {
            $json['message'] = "Total Marks Should Not Exceed Full Marks";
        }

        
        echo json_encode($json);
    }

    //Teacher Side
    public function register_mark_teacher(Request $request){
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $data['getExam'] = ExamScheduleModel::getExamTeacher(Auth::user()->id);

        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $data['getSubject'] = ExamScheduleModel::getExamTimetable($request->get('exam_id'),$request->get('class_id'));
            $data['getStudentClass'] = User::getStudentClass($request->get('class_id'));
        }
        $data['header_title'] = "Register Mark";
        return view('ogretmen.register_mark', $data);
    }

    //Student Side
    public function my_exam_result()
    {
        $result = array();
        $getExam = MarkRegisterModel::getExam(Auth::user()->id);

        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $getExamSubject = MarkRegisterModel::getExamSubject($value->exam_id, Auth::user()->id);
            $dataSubject = array();
            foreach($getExamSubject as $exam)
            {
                $total_score = $exam['class_work'] * 0.2 + $exam['home_work'] * 0.2 + $exam['exam_mark'] * 0.6;
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['exam_mark'] = $exam['exam_mark'];
                $dataS['total_score'] = $total_score;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_marks'] = $exam['passing_marks'];
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = "Marks Result";
        return view('ogrenci.register_mark', $data);
    }

    //Parent Side
    public function MyStudentExamResults($student_id)
    {
        $result = array();
        $getExam = MarkRegisterModel::getExam($student_id);

        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $getExamSubject = MarkRegisterModel::getExamSubject($value->exam_id, $student_id);
            $dataSubject = array();
            foreach($getExamSubject as $exam)
            {
                $total_score = $exam['class_work'] * 0.2 + $exam['home_work'] * 0.2 + $exam['exam_mark'] * 0.6;
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['exam_mark'] = $exam['exam_mark'];
                $dataS['total_score'] = $total_score;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_marks'] = $exam['passing_marks'];
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = "Students Marks Result";
        return view('veli.exam_result', $data);
    }

    
}
