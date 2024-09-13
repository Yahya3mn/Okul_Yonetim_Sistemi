@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Exam Results</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          @foreach ($getRecord as $value)
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ $value['exam_name'] }} </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Subject Name</th>
                      <th>Class Work</th>
                      <th>Home Work</th>
                      <th>Exam Mark</th>
                      <th>Full Marks</th>
                      <th>Passing Marks</th>
                      <th>Total Score</th>
                      <th>Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $total_score = 0;   
                      $full_marks = 0;   
                    @endphp
                    @foreach ($value['subject'] as $subject)
                    @php
                    $total_score += $subject['total_score'];   
                    $full_marks += $subject['full_marks'];   
                    @endphp
                    <tr>
                      <td>{{ $subject['subject_name'] }}</td>
                      <td>{{ $subject['class_work'] }}</td>
                      <td>{{ $subject['home_work'] }}</td>
                      <td>{{ $subject['exam_mark'] }}</td>
                      <td>{{ $subject['full_marks'] }}</td>
                      <td>{{ $subject['passing_marks'] }}</td>
                      <td>{{ $subject['total_score'] }}</td>
                      <td>
                        @if($subject['total_score'] >= $subject['passing_marks'] )
                            <span style="color: green; font-weight: bold;">Passed</span>
                        @else
                            <span style="color: red; font-weight: bold;">Failed</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="100%"><b>Average Score: {{ round(($total_score * 100) / $full_marks)  }}</b></td>
                    </tr>
                    <tr>
                      <td colspan="100%"> 
                        <b>
                          Grade : 
                          @php
                          $getGrade = App\Models\MarkGradeModel::getGrade(($total_score * 100) / $full_marks);
                          print_r($getGrade);
                          @endphp
                        </b>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
</div>

@endsection
