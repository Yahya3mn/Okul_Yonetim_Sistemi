@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Grade</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <form method="post" action="">
                {{ csrf_field() }}
                <div class="card-body">
                   <div class="form-group">
                        <label>Grade Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name',  $getRecord->name) }}" required placeholder="Grade Name">
                   </div>

                   <div class="form-group">
                    <label>Percent From</label>
                    <input type="number" class="form-control" name="percent_from" value="{{ old('percent_from',  $getRecord->percent_from) }}"  placeholder="Percent From">
                   </div>

                <div class="form-group">
                <label>Percent To</label>
                <input type="number" class="form-control" name="percent_to" value="{{ old('percent_to',  $getRecord->percent_to) }}" required placeholder="Percent To">
                </div>
                  
                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>


          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>



@endsection