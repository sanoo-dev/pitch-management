@extends('layouts.admin')

@section('title', 'Khách hàng')

@section('css')
<link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">THÊM KHÁCH HÀNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customer</a></li>
        <li class="breadcrumb-item active">Create</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Thêm khách hàng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.customers.store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="row">
          <div class="form-group col-sm-12">
            <label for="name">Tên khách hàng *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group col-sm-12">
            <label for="phone_number">Số điện thoại *</label>
            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" id="phone_number">
            @error('phone_number')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <input type="hidden" name="times_booked" value="0">
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
