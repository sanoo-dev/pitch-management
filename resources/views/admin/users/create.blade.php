@extends('layouts.admin')

@section('title', 'Người dùng')

@section('css')
@endsection

@section('js')
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">THÊM NGƯỜI DÙNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User</a></li>
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
      <h3 class="card-title">Thêm người dùng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.users.store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="row">
          <div class="form-group col-sm-12">
            <label for="name">Tên người dùng *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="birthday">Ngày sinh *</label>
            <input type="text" name="birthday" class="form-control @error('birthday') is-invalid @enderror" value="{{ old('birthday') }}" id="birthday">
            @error('birthday')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="phone">Số điện thoại *</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" id="phone">
            @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="identity">CMND/CCCD *</label>
            <input type="text" name="identity" class="form-control @error('identity') is-invalid @enderror" value="{{ old('identity') }}" id="identity">
            @error('identity')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="address">Địa chỉ *</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" id="address">
            @error('address')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="email">Email *</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email">
            @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="password">Mật khẩu *</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="password">
            @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="confirm-password">Nhập lại mật khẩu *</label>
            <input type="password" name="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" value="{{ old('confirm-password') }}" id="confirm-password">
            @error('confirm-password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Chọn vai trò</label>
              <select multiple class="form-control" name="roles[]" required>
                @foreach($roles as $role)
                <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
              </select>
              @error('roles')
              <div class="error invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
