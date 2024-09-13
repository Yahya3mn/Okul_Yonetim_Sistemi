<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkGradeModel extends Model
{
    use HasFactory;

    protected $table = "mark_grade";

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return self::select('mark_grade.*', 'users.name as created_name')
                    ->join('users','users.id', '=', 'mark_grade.created_by')
                    ->where('mark_grade.is_delete', '=', 0)
                    ->get();
    }

    static public function getGrade($avg)
    {
        $return = self::select('mark_grade.*', )
                    ->where('percent_from', '<=', $avg)
                    ->where('percent_to', '>=', $avg)
                    ->first();
        return !empty($return->name) ? $return->name : '';
    }
}
