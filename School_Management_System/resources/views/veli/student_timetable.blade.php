@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Timetable</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="container-fluid">
        <div class="row">
          
          <!-- /.col -->
          <div class="col-md-12">

             
            <div class="card">
                <div class="card-header">
                  <h2 class="card-title" style="font-size: 24px; color: blue;">({{ $getClass->name }}) - ({{ $getSubject->name }}) -- ({{$getStudent->name}} {{$getStudent->last_name}})</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Week</th>
                            <th>Sart Time</th>
                            <th>End Time</th>
                            <th>Room Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getRecord as $valueW)
                        <tr>

                            <td>
                                {{$valueW['week_name']}}
                            </td>
                                
                            <td>
                                {{$valueW['start_time']}}
                            </td>

                            <td>
                                {{$valueW['end_time']}}
                            </td>

                            <td>
                                {{$valueW['room_number']}}
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              

          </div>
        </div>
    </section>
  </div>



@endsection


