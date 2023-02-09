@extends('layouts.admin')

@section('title', 'Loại dịch vụ')

@section('css')
@endsection

@section('js')
@endsection

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">CẬP NHẬT LOẠI DỊCH VỤ</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.service-types.index') }}">Pitch Type</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Cập nhật loại dịch vụ</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.service-types.update', $serviceType) }}" method="post">
            @method('patch')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên loại dịch vụ *</label>
                    <input type="text" name="name" value="{{ old('name') !== null ? old('name') : $serviceType->name }}" class="form-control @error('name') is-invalid @enderror" id="name">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.service-types.index') }}" class="btn btn-default">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
