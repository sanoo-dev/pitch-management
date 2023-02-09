@extends('layouts.admin')

@section('title', 'Đặt sân')

@section('css')
@endsection

@section('js')
<script>
   // Get Date
   let booking_date = $('#booking_date').val()
   let hour_start = $('#hour_start').val()
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
     hour_start = $('#hour_start').val()
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
      <h1 class="m-0">CẬP NHẬT ĐẶT SÂN BÓNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}?date={{ $date }}">Booked</a></li>
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
      <h3 class="card-title">Cập nhật đặt sân bóng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.orders.update', $order) }}" method="post">
      @method('patch')
      @csrf
      <input type="hidden" name="employee_id" value="{{ auth()->user()->id }}">
      <div class="card-body">
        <div class="form-group">
          <label>Tên sân bóng *</label>
          <select id="pitch_id" class="form-control @error('pitch_id') is-invalid @enderror" name="pitch_id">
            <option selected disabled>Chọn sân...</option>
            @foreach ($pitches as $pitch)
            <option
                data-price="{{ $pitch->pitchType->price }}"
                value="{{ $pitch->id }}"
                {{ old('pitch_id') ? (old('pitch_id') == $pitch->id ? 'selected' : '') : ($pitch->id == $order->pitch_id ? 'selected' : '') }}
            >{{ $pitch->name }}</option>
            @endforeach
          </select>
          @error('pitch_id')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label>Số điện thoại khách hàng *</label>
          <input type="text" value="{{ $order->customer->phone_number }}" class="form-control" id="customer_phone_number" readonly>
        </div>

        <div class="form-group">
          <label for="customer_name">Tên khách hàng *</label>
          <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
          <input type="text" value="{{ $order->customer->name }}" class="form-control" id="customer_name" readonly>
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
                <input type="hidden" id="hour_start" name="hour_start" value="{{ date('H', strtotime($order->time_start)) }}">
                <select class="custom-select" required disabled>
                  <option>{{ date('H', strtotime($order->time_start)) }}</option>
                </select>
              </div>
              <div class="col-sm-3">
                <label>Phút</label>
                <input type="hidden" id="minute_start" name="minute_start" value="{{ date('i', strtotime($order->time_start)) }}">
                <select class="custom-select" required disabled>
                  <option>{{ date('i', strtotime($order->time_start)) == 0 ? '00' : date('i', strtotime($order->time_start)) }}</option>
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
                <select class="custom-select @error('time_end') is-invalid @enderror" id="hour_end" name="hour_end" required>
                  @foreach ( range(0, 23) as $hour)
                  <option value="{{ $hour }}" {{ old('hour_end') ? (old('hour_end') == $hour ? 'selected' : '') : ($hour==date('H', strtotime($order->time_end)) ? 'selected' : '') }}>{{ $hour < 10 ? '0' . $hour : $hour }}</option>
                  @endforeach
                </select>
                @error('time_end')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-sm-3">
                <label>Phút</label>
                <select class="custom-select @error('time_end') is-invalid @enderror" id="minute_end" name="minute_end" required>
                  @foreach ([0, 15, 30, 45] as $minute)
                  <option value="{{ $minute }}" {{ old('minute_end') ? (old('minute_end')==$minute ? 'selected' : '') : ($minute==date('i', strtotime($order->time_end)) ? 'selected' : '') }}>{{ $minute == 0 ? '00' : $minute }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <input type="hidden" id="time_end" name="time_end" value="">
          </div>
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
