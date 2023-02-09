@extends('layouts.admin')

@section('title', 'Cài đặt')

@section('css')
@endsection

@section('js')
<script>
  let hour_start = $('#hour_start').val() < 10 ? '0' + $('#hour_start').val() : $('#hour_start').val()
  let minute_start = $('#minute_start').val() == 0 ? '00' : $('#minute_start').val()
  let hour_end = $('#hour_end').val() < 10 ? '0' + $('#hour_end').val() : $('#hour_end').val()
  let minute_end = $('#minute_end').val() == 0 ? '00' : $('#minute_end').val()
  $(document).ready(function() {
    $('#open_time').val(hour_start + ":" + minute_start)
    $('#close_time').val(hour_end + ":" + minute_end)
  });

  $('select').on('change', function() {
    minute_start = $('#minute_start').val() == 0 ? '00' : $('#minute_start').val()
    hour_end = $('#hour_end').val() < 10 ? '0' + $('#hour_end').val() : $('#hour_end').val()
    minute_end = $('#minute_end').val() == 0 ? '00' : $('#minute_end').val()
    $('#open_time').val(hour_start + ":" + minute_start)
    $('#close_time').val(hour_end + ":" + minute_end)
  });

</script>
@endsection
@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">CÀI ĐẶT</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active">Setting</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Cài đặt</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.settings.update', $setting) }}" method="post">
      @method('patch')
      @csrf
      <div class="card-body">
        <div class="row">
          <div class="form-group col-md-6">
            <label for="open_time">Thời gian mở cửa *</label>
            <div class="form-row">
              <div class="col-sm-3">
                <label>Giờ</label>
                <select id="hour_start" class="custom-select @error('open_time') is-invalid @enderror" name="hour_start" required>
                  @foreach ( range(0, 23) as $hour)
                  <option value="{{ $hour }}" {{ old('hour_start') ? (old('hour_start') == $hour ? 'selected' : '') : ($hour==date('H', strtotime($setting->open_time)) ? 'selected' : '') }}>{{ $hour }}</option>
                  @endforeach
                </select>
                @error('open_time')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-sm-3">
                <label>Phút</label>
                <select id="minute_start" class="custom-select @error('open_time') is-invalid @enderror" name="minute_start" required>
                  @foreach ([0, 15, 30, 45] as $minute)
                  <option value="{{ $minute }}" {{ old('minute_start') ? (old('minute_start') == $minute ? 'selected' : '') : ($minute==date('i', strtotime($setting->open_time)) ? 'selected' : '') }}>{{ $minute == 0 ? '00' : $minute }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <input type="hidden" id="open_time" name="open_time" value="">
          </div>

          <div class="form-group col-md-6">
            <label for="close_time">Thời gian đóng cửa *</label>
            <div class="form-row">
              <div class="col-sm-3">
                <label>Giờ</label>
                <select id="hour_end" class="custom-select @error('close_time') is-invalid @enderror" name="hour_end" required>
                  @foreach ( range(0, 23) as $hour)
                  <option value="{{ $hour }}" {{ old('hour_end') ? (old('hour_end') == $hour ? 'selected' : '') : ($hour==date('H', strtotime($setting->close_time)) ? 'selected' : '') }}>{{ $hour }}</option>
                  @endforeach
                </select>
                @error('close_time')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-sm-3">
                <label>Phút</label>
                <select id="minute_end" class="custom-select @error('close_time') is-invalid @enderror" name="minute_end" required>
                  @foreach ([0, 15, 30, 45] as $minute)
                  <option value="{{ $minute }}" {{ old('minute_end') ? (old('minute_end') == $minute ? 'selected' : '') : ($minute==date('i', strtotime($setting->close_time)) ? 'selected' : '') }}>{{ $minute == 0 ? '00' : $minute }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <input type="hidden" id="close_time" name="close_time" value="">

          <div class="form-group col-sm-12">
            <label for="phone">Số điện thoại *</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') !== null ? old('phone') : $setting->phone }}" id="phone">
            @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-sm-12">
            <label for="location">Địa chỉ *</label>
            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') !== null ? old('location') : $setting->location }}" id="location">
            @error('location')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-sm-12">
            <label for="location_url">Url map *</label>
            <input type="text" name="location_url" class="form-control @error('location_url') is-invalid @enderror" value="{{ old('location_url') !== null ? old('location_url') : $setting->location_url }}" id="location_url">
            @error('location_url')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-sm-12">
            <label for="email">Email *</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') !== null ? old('email') : $setting->email }}" id="email">
            @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
