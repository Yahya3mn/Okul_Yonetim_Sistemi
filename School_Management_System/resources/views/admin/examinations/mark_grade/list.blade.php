@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mark Grade</h1>
          </div>
          <div class="col-sm-6" style="text-align: right;">
            <a href="{{url('admin/examinations/mark_grade/add')}}" class="btn btn-primary">Add New Grade</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    

   
    <section class="content">
      
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">

            @include('_message')

           
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Mark Grade </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Grade Name</th>
                      <th>Percent From</th>
                      <th>Percent To</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($getRecord as $value)
                          <tr>
                            <td>
                              {{ $value->name }}
                            </td>
                            <td>
                              {{ $value->percent_from }}
                            </td>
                            <td>
                                {{$value->percent_to}}
                            </td>
                            <td>
                                {{ $value->created_name }}
                            </td>
                            <td>
                              {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}
                            </td>
                            <td>
                              <a href="{{url('admin/examinations/mark_grade/edit/' . $value->id)}}" class="btn btn-primary btn-sm">Edit</a>
                              <a href="{{url('admin/examinations/mark_grade/delete/' . $value->id)}}" class="btn btn-danger btn-sm">Delete</a>
                            </td>

                          </tr>
                      @endforeach
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>



@endsection