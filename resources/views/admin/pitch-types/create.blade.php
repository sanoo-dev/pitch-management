@extends('layouts.admin')

@section('title', 'Loại sân bóng')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })

</script>

<script>
  $(document).ready(function() {
    $('#description').summernote({
      height: 200
    });
  });

</script>

<script>
    $(document).ready(function() {
      $('#introduce').summernote({
        height: 200
      });
    });

</script>
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">THÊM LOẠI SÂN BÓNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pitch-types.index') }}">Pitch Type</a></li>
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
      <h3 class="card-title">Thêm loại sân bóng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.pitch-types.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Tên loại sân *</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
          @error('name')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="price">Đơn giá (đ/phút) *</label>
          <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" id="price">
          @error('price')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="image">Hình ảnh</label><span class="text-sm"> (Nên chọn ảnh tỷ lệ 4:3)</span>
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image">
              <label class="custom-file-label" for="image">Chọn hình ảnh</label>
            </div>
            @error('image')
            <span class="text-sm text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="description">Mô tả</label>
          <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
          @error('description')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="introduce">Giới thiệu</label>
            <textarea name="introduce" id="introduce" class="form-control @error('introduce') is-invalid @enderror">{{ old('introduce') }}</textarea>
            @error('introduce')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

        <div class="form-group">
          <label for="price">Sức chứa (người) *</label>
          <input type="text" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity') }}" id="capacity">
          @error('capacity')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('admin.pitch-types.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
