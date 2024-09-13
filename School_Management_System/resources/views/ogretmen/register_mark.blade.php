@extends('layouts.app')
@section('content')
<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Marks Register </h1>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Marks Register</h3>
                  </div>
                  <form method="get" action="">
                     <div class="card-body">
                        <div class="row">
                           <div class="form-group col-md-3">
                              <label>Exam </label>
                              <select class="form-control" name="exam_id", required>
                                 <option value="">Select</option>
                                 @foreach($getExam as $exam)
                                 <option {{(Request::get('exam_id') == $exam->exam_id) ? 'selected' : ''}} value="{{$exam->exam_id}}">{{$exam->exam_name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group col-md-3">
                              <label>Class </label>
                              <select class="form-control" name="class_id" required>
                                 <option value="">Select</option>
                                 @foreach($getClass as $class)
                                 <option {{(Request::get('class_id') == $class->class_id) ? 'selected' : ''}} value="{{$class->class_id}}">{{$class->class_name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group col-md-3">
                              <button class="btn btn-primary" type="submit" style="margin-top: 31px;">Search</button>
                              <a href="{{url('admin/examinations/exam_marks_register')}}" class="btn btn-success" style="margin-top: 31px;">Reset</a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               @include('_message')
               @if(!empty($getSubject) && !empty($getSubject->count()))
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Marks Register </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0" style="overflow: auto;">
                     <table class="table table-striped">
                        <thead>
                           <tr >
                              <th style="min-width: 160px;">STUDENT NAME</th>
                              @foreach($getSubject as $subject)
                              <th style="min-width: 160px;">
                                 {{$subject->subject_name}} <br />
                                 ({{$subject->subject_type}} : {{$subject->passing_marks}} / {{$subject->full_marks}})
                              </th>
                              @endforeach
                              <th>ACTION</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if(!empty($getStudentClass) && !empty($getStudentClass->count()))
                           @foreach ($getStudentClass as $student)
                           <form action="POST" action="{{ url('admin/examinations/submit_marks_register') }}" class="SubmitForm">
                            {{ csrf_field() }}
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                            <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                              <tr>
                                 <td>{{$student->name}} {{$student->last_name}}</td>
                                 @php
                                 $i = 1;
                                 $totalStudentMark = 0;
                                 $totalFullMark = 0;
                                 $totalPassingMark = 0;
                                 @endphp
                                 @foreach ($getSubject as $subject)
                                 @php
                                 $totalMark = 0;
                                 $totalFullMark += $subject->full_marks;
                                 $totalPassingMark += $subject->passing_marks;
                                 $getMark = $subject->getMark($student->id, Request::get('class_id'), Request::get('exam_id'),$subject->subject_id);
                                 $totalMark = $getMark->class_work * 0.2 + $getMark->home_work * 0.2 + $getMark->exam_mark * 0.6;
                                 $totalStudentMark += $totalMark;
                                 @endphp
                                 <td>
                                    <div style="margin-bottom: 10px;">
                                       Class Work
                                       <input type="hidden" name="mark[{{$i}}][full_marks]" value="{{$subject->full_marks}}">
                                       <input type="hidden" name="mark[{{$i}}][passing_marks]" value="{{$subject->passing_marks}}">

                                       <input type="hidden" name="mark[{{$i}}][id]" value="{{$subject->id}}">
                                       <input type="hidden" name="mark[{{$i}}][subject_id]" value="{{$subject->subject_id}}">
                                       <input type="text" value="{{ !empty($getMark->class_work) ? $getMark->class_work : '' }}" name="mark[{{$i}}][class_work]" 
                                             id="class_work_{{$student->id}}{{$subject->subject_id}}" style="width: 200px; border-radius: 100px;" class="form-control" placeholder="Enter Marks">
                                    </div>
                                    <div style="margin-bottom: 10px;">
                                       Home Work
                                       <input type="hidden" name="mark[{{$i}}][subject_id]" value="{{$subject->subject_id}}">
                                       <input type="text" value="{{ !empty($getMark->home_work) ? $getMark->home_work : '' }}"  name="mark[{{$i}}][home_work]" 
                                              id="home_work_{{$student->id}}{{$subject->subject_id}}" style="width: 200px;  border-radius: 100px;" class="form-control" placeholder="Enter Marks">
                                    </div>
                                    <div style="margin-bottom: 10px;">
                                       Exam Mark
                                       <input type="hidden" name="mark[{{$i}}][subject_id]" value="{{$subject->subject_id}}">
                                       <input type="text" value="{{ !empty($getMark->exam_mark) ? $getMark->exam_mark : '' }}"  name="mark[{{$i}}][exam_mark]" 
                                              id="exam_mark_{{$student->id}}{{$subject->subject_id}}" style="width: 200px;  border-radius: 100px;" class="form-control" placeholder="Enter Marks">
                                    </div>

                                    <div style="margin-bottom: 10px;">
                                       <span><b>Result</b></span>
                                       <output type="text" value="{{ $totalMark }}" style="width: 200px;  border-radius: 10px;" class="form-control">
                                          @php
                                          echo "<b>Results</b>: " . $totalMark;
                                          @endphp
                                       </output>
                                       <p>
                                          @php
                                          echo "<b>Passing Marks</b>: " . $subject->passing_marks;
                                          @endphp
                                       </p>
                                       @if( $totalMark >= $subject->passing_marks)
                                          <span style="color: green; font-weight: bold;">Passed</span>
                                       @else
                                          <span style="color: red; font-weight: bold;">Failed</span>
                                          @php
                                           $pass_fail_validation = 1;   
                                          @endphp
                                       @endif
                                    </div> 
                                       
                                    <div style="margin-bottom: 10px;">
                                       <button type="button" class="btn btn-primary SaveSingleSubject" style="border-radius: 10px;" id="{{$student->id}}" data-val="{{$subject->subject_id}}" 
                                          data-exam="{{Request::get('exam_id')}}" data-class="{{ Request::get('class_id') }}" data-schedule="{{ $subject->id }}">Save</button>
                                    </div>

                                 </td>
                                 @php
                                 $i++;
                                 @endphp
                                 @endforeach
                                 <td>
                                    <button type="submit" class="btn btn-success" style="border-radius: 10px;">Save All</button>
                                    <br />
                                    <br />
                                    <br />
                                    <br />
                                    <b>Average Mark</b>
                                    <output type="text" value="{{ $totalMark }}" style="width: 200px;  border-radius: 10px;" class="form-control">
                                       @php
                                           $avg = ($totalStudentMark * 100) / $totalFullMark;
                                           echo $avg . '%';
                                       @endphp
                                    </output>
                                    <b>Grade</b>
                                       <output type="text" style="width: 200px;  border-radius: 10px;" class="form-control">
                                          @php
                                               $getGrade = App\Models\MarkGradeModel::getGrade($avg);
                                               print_r($getGrade);
                                          @endphp
                                       </output>
                                 </td>
                                
                              </tr>
                           </form>
                           @endforeach
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
               @endif
            </div>
         </div>
      </div>
   </section>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('.SubmitForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url : "{{ url('ogretmen/submit_marks_register') }}",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data){
                alert('Marks saved successfully!');
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
            }
        });
    });

    $('.SaveSingleSubject').click(function(e){
      var student_id = $(this).attr('id');
      var subject_id = $(this).attr('data-val');
      var exam_id = $(this).attr('data-exam');
      var class_id = $(this).attr('data-class');
      var id = $(this).attr('data-schedule');
      var class_work = $('#class_work_'+student_id+subject_id).val();
      var home_work = $('#home_work_'+student_id+subject_id).val();
      var exam_mark = $('#exam_mark_'+student_id+subject_id).val();

      $.ajax({
            type: "POST",
            url : "{{ url('ogretmen/submit_single_marks_register') }}",
            data: {
               "_token" : "{{ csrf_token() }}",
               id : id,
               student_id : student_id,
               subject_id : subject_id,
               exam_id : exam_id,
               class_id : class_id,
               class_work : class_work,
               home_work : home_work,
               exam_mark : exam_mark,
            },
            dataType: "json",
            success: function(data){
                alert('Marks saved successfully!');
            }
        });
    });

</script>


@endsection