@extends('layouts.admin')

@section('title', 'Đặt sân bóng')

@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript">
    // lấy data customer
  $(document).ready(function() {
    $('#customer_phone_number').on('keyup', function() {
      var customer_phone_number = $(this).val();
      if (customer_phone_number) {
        $.ajax({
          url: "{{ url('admin/customers/get') }}/" + customer_phone_number
          , type: "GET"
          , dataType: "json"
        }).done(function(data) {
          if (data.length > 0) {
            $('#customer_id').val(data[0].id);
            $('#customer_name').val(data[0].name);
            $('#customer_name').prop('readonly', true);
          } else {
            $('#customer_id').val('');
            $('#customer_name').val('');
            $('#customer_name').prop('readonly', false);
          }
        });
      }
    });
  });

</script>
<script type="text/javascript">
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

</script>

<script>
  // Get Date
  let booking_date = $('#booking_date').val()
  let hour_start = $('#hour_start').val() < 10 ? '0' + $('#hour_start').val() : $('#hour_start').val()
  let minute_start = $('#minute_start').val() == 0 ? '00' : $('#minute_start').val()
  let hour_end = $('#hour_end').val() < 10 ? '0' + $('#hour_end').val() : $('#hour_end').val()
  let minute_end = $('#minute_end').val() == 0 ? '00' : $('#minute_end').val()

  // Calculate Price
  let price = $('select[name=pitch_id]').find(':selected').attr('data-price') ? $('select[name=pitch_id]').find(':selected').attr('data-price') : 0;
  let weekend = new Date(booking_date).getDay();


  $(document).ready(function() {
    $('#price').val(price)
    $('#time_start').val(booking_date + " " + hour_start + ":" + minute_start)
    $('#time_end').val(booking_date + " " + hour_end + ":" + minute_end)
  });


  // When select pitch change
  $('select[name=pitch_id]').on('change', function() {
    price = $(this).find(':selected').attr('data-price');
    $('#price').val(price)
  })

  $('select[name=hour_start], select[name=hour_end], select[name=minute_start], select[name=minute_end]').on('change', function() {
    hour_start = $('#hour_start').val() < 10 ? '0' + $('#hour_start').val() : $('#hour_start').val()
    minute_start = $('#minute_start').val() == 0 ? '00' : $('#minute_start').val()
    hour_end = $('#hour_end').val() < 10 ? '0' + $('#hour_end').val() : $('#hour_end').val()
    minute_end = $('#minute_end').val() == 0 ? '00' : $('#minute_end').val()

    // Change date
    $('#time_start').val(booking_date + " " + hour_start + ":" + minute_start)
    $('#time_end').val(booking_date + " " + hour_end + ":" + minute_end)

    // Change price
    $('#price').val(price)
  });

</script>

@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">ĐẶT SÂN BÓNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pitch-booking-status.index') }}?date={{ $date }}">Pitch</a></li>
        <li class="breadcrumb-item active">Order</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
@php
date_default_timezone_set('Asia/Ho_Chi_Minh');
@endphp
<div class="container-fluid">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Đặt sân bóng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.orders.store') }}" method="post">
      @csrf
      <input type="hidden" name="employee_id" value="{{ auth()->user()->id }}">
      <div class="card-body">
        <div class="form-group">
          <label>Tên sân bóng *</label>
          <select id="pitch_id" class="form-control @error('pitch_id') is-invalid @enderror" name="pitch_id">
            <option selected disabled>Chọn sân...</option>
            @foreach ($pitches as $pitch)
            <option data-price="{{ $pitch->pitchType->price }}" value="{{ $pitch->id }}" @if(old('pitch_id')==$pitch->id) selected @endif>{{ $pitch->name }}</option>
            @endforeach
          </select>
          @error('pitch_id')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="customer_phone_number">Số điện thoại khách hàng *</label>
            <input type="text" name="customer_phone_number" value="{{ old('customer_phone_number') }}" class="form-control @error('customer_phone_number') is-invalid @enderror" id="customer_phone_number">
            @error('customer_phone_number')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-md-6">
            <label for="customer_name">Tên khách hàng *</label>
            <input type="hidden" id="customer_id" name="customer_id" value="">
            <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name">
            @error('customer_name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>


        <div class="row">
          <div class="form-group col-md-6">
            <label for="booking_date">Ngày đặt *</label>
            <input type="text" id="booking_date" name="booking_date" value="{{ old('booking_date') ? old('booking_date') : $date }}" class="form-control" readonly>
          </div>

          <div class="form-group col-md-6">
            <label for="price">Đơn giá dự kiến (*/phút) <small class="text-danger">* thay đổi theo khung giờ</small></label>
            <input name="price" id="price" type="text" value="0" class="form-control" readonly>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label for="time_start">Thời gian bắt đầu *</label>
            <div class="form-row">
              <div class="col-sm-3">
                <label>Giờ</label>
                <select id="hour_start" class="custom-select @error('time_start') is-invalid @enderror" name="hour_start" required>
                  @foreach (range(0, 23) as $hour)
                  <option value="{{ $hour }}" {{ old('hour_start') ? (old('hour_start') == $hour ? 'selected' : '') : ($hour==date('H')+1 ? 'selected' : '') }}>{{ $hour < 10 ? '0' . $hour : $hour }}</option>
                  @endforeach
                </select>
                @error('time_start')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-sm-3">
                <label>Phút</label>
                <select id="minute_start" class="custom-select @error('time_start') is-invalid @enderror" name="minute_start" required>
                  @foreach ([0, 15, 30, 45] as $minute)
                  <option value="{{ $minute }}" @if(old('minute_start')==$minute) selected @endif>{{ $minute == 0 ? '00' : $minute }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <input type="hidden" id="time_start" name="time_start" value="">
          </div>

          <div class="form-group col-md-6">
            <label for="time_end">Thời gian kết thúc *</label>
            <div class="form-row">
              <div class="col-sm-3">
                <label>Giờ</label>
                <select id="hour_end" class="custom-select @error('time_end') is-invalid @enderror" name="hour_end" required>
                  @foreach ( range(0, 23) as $hour)
                  <option value="{{ $hour }}" {{ old('hour_end') ? (old('hour_end') == $hour ? 'selected' : '') : ($hour==date('H')+2 ? 'selected' : '') }}>{{ $hour < 10 ? '0' . $hour : $hour }}</option>
                  @endforeach
                </select>
                @error('time_end')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-sm-3">
                <label>Phút</label>
                <select id="minute_end" class="custom-select @error('time_end') is-invalid @enderror" name="minute_end" required>
                  @foreach ([0, 15, 30, 45] as $minute)
                  <option value="{{ $minute }}" @if(old('minute_end')==$minute) selected @endif>{{ $minute == 0 ? '00' : $minute }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <input type="hidden" id="time_end" name="time_end" value="">
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Xác nhận</button>
        <a href="{{ route('admin.orders.index') }}?date={{ $date }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
