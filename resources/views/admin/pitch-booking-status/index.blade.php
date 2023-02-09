@extends('layouts.admin')

@section('title', 'Tình trạng đặt sân')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/timetable/timetablejs.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/timetable/demo.css') }}">
<script src="{{ asset('backend/plugins/timetable/timetable.js') }}"></script>
<link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script>
  $.ajax({
    url: "{{ url('admin/pitches/get/all') }}"
    , type: "GET"
    , dataType: "json"
  }).done(function(pitches) {
    var pitchNames = [];

    for (var pitch of pitches) {
      pitchNames.push(pitch.name);
    }

    if (pitchNames.length > 0) {
      var timetable = new Timetable();
      timetable.setScope(0, 23)
      timetable.addLocations(pitchNames);

      var date = $('#date').val();
      $.ajax({
        url: "{{ url('admin/orders/get') }}/" + date
        , type: "GET"
        , dataType: "json"
      }).done(function(data) {
        data = data.data
        for (var order of data) {
          timetable.addEvent(order.customer_name, order.pitch_name, new Date(order.time_start), new Date(order.time_end), {
            url: '#'
          });
        }

        var renderer = new Timetable.Renderer(timetable);
        renderer.draw('.timetable');
      });

    }
  });

</script>
<script>
  $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
    icons: {
      time: 'fas fa-clock'
      , date: 'fas fa-calendar'
      , up: 'fas fa-arrow-up'
      , down: 'fas fa-arrow-down'
      , previous: 'fas fa-chevron-left'
      , next: 'fas fa-chevron-right'
      , today: 'fas fa-calendar-check-o'
      , clear: 'fas fa-trash'
      , close: 'fas fa-times'
    }
  });

  $(function() {
    $('#date').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });

</script>

@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">TÌNH TRẠNG SÂN</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active">Booking Status</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-3">
    <div>
      <form action="{{ route('admin.pitch-booking-status.index') }}" method="get">
        <strong>Chọn ngày:</strong>
        <input type="text" name="date" class="datetimepicker-input" data-toggle="datetimepicker" data-target="#date" id="date" value="{{ $date }}" required>
        <button type="submit" class="btn btn-sm btn-primary">Duyệt</button>
      </form>
    </div>
    <a href="{{ route('admin.orders.create', $date) }}" class="btn btn-sm btn-success">Đặt sân</a>
  </div>
  <div class="timetable"></div>
</div>
@endsection
