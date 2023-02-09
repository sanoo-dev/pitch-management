@extends('layouts.admin')

@section('title', 'Hồ sơ')

@section('css')
@endsection

@section('js')
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">CẬP NHẬT HỒ SƠ</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User</a></li>
        <li class="breadcrumb-item active">Edit Profile</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Cập nhật người dùng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.users.update', $user->id) }}" method="post">
      @method('patch')
      @csrf
      <div class="card-body">
        <div class="row">
          <div class="form-group col-sm-12">
            <label for="name">Tên người dùng *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') !== null ? old('name') : $user->name }}" id="name" readonly>
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="birthday">Ngày sinh *</label>
            <input type="text" name="birthday" class="form-control @error('birthday') is-invalid @enderror" value="{{ old('birthday') !== null ? old('birthday') : $user->birthday }}" id="birthday" readonly>
            @error('birthday')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="phone">Số điện thoại *</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') !== null ? old('phone') : $user->phone }}" id="phone" readonly>
            @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="identity">CMND/CCCD *</label>
            <input type="text" name="identity" class="form-control @error('identity') is-invalid @enderror" value="{{ old('identity') !== null ? old('identity') : $user->identity }}" id="identity" readonly>
            @error('identity')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="address">Địa chỉ *</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') !== null ? old('address') : $user->address }}" id="address" readonly>
            @error('address')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="email">Email *</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') !== null ? old('email') : $user->email }}" id="email" readonly>
            @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
            @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label for="confirm-password">Nhập lại mật khẩu</label>
            <input type="password" name="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" id="confirm-password">
            @error('confirm-password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Chọn vai trò</label>
              <select multiple class="form-control" name="roles[]" readonly>
                @foreach($roles as $role)
                <option @if(in_array($role, $user->getRoleNames()->toArray())) selected @endif value="{{ $role }}">{{ $role }}</option>
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
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
