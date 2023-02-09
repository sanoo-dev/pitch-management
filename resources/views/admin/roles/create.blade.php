@extends('layouts.admin')

@section('title', 'Vai trò')

@section('css')
@endsection

@section('js')
@endsection

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">THÊM VAI TRÒ</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Role</a></li>
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
            <h3 class="card-title">Thêm vai trò</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.roles.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="name">Tên vai trò *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <label>Quyền</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-6 col-sm-4 col-lg-3">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="permission[]" id="{{ $permission->id }}" value="{{ $permission->id }}">
                                        <label for="{{ $permission->id }}" class="custom-control-label">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Thêm</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
