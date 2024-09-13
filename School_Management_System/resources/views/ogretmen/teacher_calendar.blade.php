@extends('layouts.app')
@section('style')
<style type="text/css">
    .fc-daygrid-event {
        white-space: normal;
    }
</style>
@endsection

@section('content')


<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Calendar</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </section>
  </div>



@endsection

@section('script')
<script src="{{asset('dist/fullcalendar/index.global.js')}}"></script>

<script type="text/javascript">
    var events = new Array();
    @foreach($getClassTimetable as $value)
        
            events.push({
                title: 'Class: {{$value->class_name}} - {{$value->subject_name}}',
                daysOfWeek: [ {{$value->fullcalendar_day}} ],
                startTime: '{{$value->start_time}}',
                endTime: '{{$value->end_time}}',
            });
        
   @endforeach

   @foreach($getExamTimetableTeacher as $valueE)
            events.push({
                title: 'Exam: {{$valueE->class_name}} - {{$valueE->exam_name}} - {{$valueE->subject_name}}  ({{$valueE->start_time}} - {{$valueE->end_time}})',
                start: '{{$valueE->exam_date}}',
                end: '{{$valueE->exam_date}}',
                color: 'red',
            });
   @endforeach

   
    var calendarID = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarID, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },

        initialDate: '<?=date('Y-m-d')?>',
        navLinks: true, 
        editable: false,
        events: events,
    });

    calendar.render();
</script>

@endsection