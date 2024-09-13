<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getAdmin(){
        $return = self::select('users.*')
                        ->where('user_type', '=', 1)
                        ->where('is_delete', '=', 0);
                        if(!empty(Request::get('name')))
                        {
                            $return = $return->where('name', 'like','%' . Request::get('name') . '%');
                        }
                        if(!empty(Request::get('email')))
                        {
                            $return = $return->where('email', 'like','%' . Request::get('email') . '%');
                        }
                        if(!empty(Request::get('date')))
                        {
                            $return = $return->whereDate('created_at', '=', Request::get('date'));
                        }
        $return = $return->orderBy('id', 'desc')
                         ->paginate(20);
        
        return $return;
    }

    static public function getTeacherStudent($teacher_id)
    {
        $return = self::select('users.*', 'class.name as class_name')
        ->join('class', 'class.id', '=', 'users.class_id')
        ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
        ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
        ->where('assign_class_teacher.status', '=', 0)
        ->where('assign_class_teacher.is_delete', '=', 0)
        ->where('users.user_type', '=', 3)
        ->where('users.is_delete', '=', 0);
        $return = $return->orderBy('users.id', 'desc')
        ->groupBy('users.id')
         ->paginate(20);

        return $return;
    }

    static public function getStudent(){
        $return = self::select('users.*', 'class.name as class_name','parent.name as parent_name', 'parent.last_name as parent_last_name')
        ->join('users as parent','parent.id','=','users.parent_id','left')
        ->join('class', 'class.id', '=', 'users.class_id', 'left')
        ->where('users.user_type', '=', 3)
        ->where('users.is_delete', '=', 0);

        if(!empty(Request::get('name')))
        {
            $return = $return->where('users.name', 'like','%' . Request::get('name') . '%');
        }

        if(!empty(Request::get('last_name')))
        {
            $return = $return->where('users.last_name', 'like','%' . Request::get('last_name') . '%');
        }

        if(!empty(Request::get('email')))
        {
            $return = $return->where('users.email', 'like','%' . Request::get('email') . '%');
        }

        if(!empty(Request::get('admission_number')))
        {
            $return = $return->where('users.admission_number', 'like','%' . Request::get('admission_number') . '%');
        }

        if(!empty(Request::get('roll_number')))
        {
            $return = $return->where('users.roll_number', 'like','%' . Request::get('roll_number') . '%');
        }

        if(!empty(Request::get('class')))
        {
            $return = $return->where('class.name', 'like','%' . Request::get('class') . '%');
        }

        if(!empty(Request::get('gender')))
        {
            $return = $return->where('users.gender', 'like','%' . Request::get('gender') . '%');
        }

        if(!empty(Request::get('caste')))
        {
            $return = $return->where('users.caste', 'like','%' . Request::get('caste') . '%');
        }

        if(!empty(Request::get('religion')))
        {
            $return = $return->where('users.religion', 'like','%' . Request::get('religion') . '%');
        }

        if(!empty(Request::get('mobile_number')))
        {
            $return = $return->where('users.mobile_number', 'like','%' . Request::get('mobile_number') . '%');
        }

        if(!empty(Request::get('blood_group')))
        {
            $return = $return->where('users.blood_group', 'like','%' . Request::get('blood_group') . '%');
        }

        if(!empty(Request::get('admission_date')))
        {
            $return = $return->whereDate('users.admission_date', '=', Request::get('admission_date'));
        }

        if(!empty(Request::get('date_of_birth')))
        {
            $return = $return->whereDate('users.date_of_birth', '=', Request::get('date_of_birth'));
        }

        if(!empty(Request::get('date')))
        {
            $return = $return->whereDate('users.created_at', '=', Request::get('date'));
        }

        if(!empty(Request::get('status')))
        {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->whereDate('users.status', '=', $status);
        }

        $return = $return->orderBy('users.id', 'desc')
         ->paginate(20);

        return $return;
    }

    static public function getStudentClass($class_id){
        return self::select('users.id', 'users.name', 'users.last_name')
        ->where('users.user_type', '=', 3)
        ->where('users.is_delete', '=', 0)
        ->where('users.class_id', '=', $class_id)
        ->orderBy('users.id', 'desc')
        ->get();

      
    }

    static public function getEmailSingle($email){
        return self::where('email', '=', $email)->first();
    }

    static public function getTokenSingle($remember_token){
        return self::where('remember_token', '=', $remember_token)->first();
    }

    public function getProfile(){
        if(!empty($this->profile_pic) && file_exists('upload/profile/' . $this->profile_pic)){
            return url('upload/profile/' . $this->profile_pic);
        }
        else{
            return "";
        }
    }

    static public function getParent(){
        $return = self::select('users.*')
        ->where('user_type', '=', 4)
        ->where('is_delete', '=', 0);
        if(!empty(Request::get('name')))
        {
            $return = $return->where('users.name', 'like','%' . Request::get('name') . '%');
        }

        if(!empty(Request::get('last_name')))
        {
            $return = $return->where('users.last_name', 'like','%' . Request::get('last_name') . '%');
        }

        if(!empty(Request::get('email')))
        {
            $return = $return->where('users.email', 'like','%' . Request::get('email') . '%');
        }

        if(!empty(Request::get('gender')))
        {
            $return = $return->where('users.gender', 'like','%' . Request::get('gender') . '%');
        }

        if(!empty(Request::get('mobile_number')))
        {
            $return = $return->where('users.mobile_number', 'like','%' . Request::get('mobile_number') . '%');
        }

        if(!empty(Request::get('occupation')))
        {
            $return = $return->where('users.occupation', 'like','%' . Request::get('occupation') . '%');
        }

        if(!empty(Request::get('address')))
        {
            $return = $return->where('users.address', 'like','%' . Request::get('address') . '%');
        }

        if(!empty(Request::get('date')))
        {
            $return = $return->whereDate('users.created_at', '=', Request::get('date'));
        }

        if(!empty(Request::get('status')))
        {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->whereDate('users.status', '=', $status);
        }


        $return = $return->orderBy('id', 'desc')
         ->paginate(20);

        return $return;
    }

    static public function getSearchStudent(){
       
       
            $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->join('users as parent','parent.id','=','users.parent_id','left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);

            if(!empty(Request::get('id')))
            {
                $return = $return->where('users.id', '=', Request::get('id'));
            }

             if(!empty(Request::get('name')))
            {
                $return = $return->where('users.name', 'like','%' . Request::get('name') . '%');
            }

            if(!empty(Request::get('last_name')))
            {
                $return = $return->where('users.last_name', 'like','%' . Request::get('last_name') . '%');
            }

            if(!empty(Request::get('email')))
            {
                $return = $return->where('users.email', 'like','%' . Request::get('email') . '%');
            }

            $return = $return->orderBy('users.id', 'desc')
            ->limit(50)
            ->get();

            return $return;
       
    }

    static public function getMyStudent($parent_id){
    
        
            $query = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id')
            ->leftJoin('class', 'class.id', '=', 'users.class_id')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0);
             $query->orderBy('users.id', 'desc')->limit(50);

            // Execute the query and return the results
            return $query->get();
        
    }

    static public function getTeacher(){
        $return = self::select('users.*')
        ->where('user_type', '=', 2)
        ->where('is_delete', '=', 0);
        if(!empty(Request::get('name')))
        {
            $return = $return->where('users.name', 'like','%' . Request::get('name') . '%');
        }

        if(!empty(Request::get('last_name')))
        {
            $return = $return->where('users.last_name', 'like','%' . Request::get('last_name') . '%');
        }

        if(!empty(Request::get('email')))
        {
            $return = $return->where('users.email', 'like','%' . Request::get('email') . '%');
        }

        if(!empty(Request::get('gender')))
        {
            $return = $return->where('users.gender', '=', Request::get('gender'));
        }

        if(!empty(Request::get('mobile_number')))
        {
            $return = $return->where('users.mobile_number', 'like','%' . Request::get('mobile_number') . '%');
        }

        if(!empty(Request::get('marital_status')))
        {
            $return = $return->where('users.marital_status', 'like','%' . Request::get('marital_status') . '%');
        }

        if(!empty(Request::get('address')))
        {
            $return = $return->where('users.address', 'like','%' . Request::get('address') . '%');
        }

        if(!empty(Request::get('perminant_address')))
        {
            $return = $return->whereDate('users.perminant_address', 'Like', '%' . Request::get('perminant_address') . '%');
        }

        if(!empty(Request::get('qualification')))
        {
            $return = $return->whereDate('users.qualification', 'Like', '%' . Request::get('qualification') . '%');
        }
        if(!empty(Request::get('work_experience')))
        {
            $return = $return->whereDate('users.work_experience', 'Like', '%' . Request::get('work_experience') . '%');
        }
        if(!empty(Request::get('note')))
        {
            $return = $return->whereDate('users.note', 'Like', '%' . Request::get('note') . '%');
        }

        if(!empty(Request::get('date')))
        {
            $return = $return->whereDate('users.date', '=',  Request::get('date'));
        }

        if(!empty(Request::get('date_of_joining')))
        {
            $return = $return->whereDate('users.date_of_joining', '=',  Request::get('date_of_joining'));
        }

        if(!empty(Request::get('status')))
        {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->whereDate('users.status', '=', $status);
        }
        $return = $return->orderBy('id', 'desc')
        ->paginate(20);

        return $return;
    }


    static public function getTeacherClass(){
        $return = self::select('users.*')
        ->where('user_type', '=', 2)
        ->where('is_delete', '=', 0);
       
        $return = $return->orderBy('id', 'desc')
        ->get();

        return $return;
    }

    static public function getAttendance($student_id, $class_id, $attendance_date)
    {
        return StudentAttendanceModel::checkAtt($student_id, $class_id, $attendance_date);
    }
    

    
}