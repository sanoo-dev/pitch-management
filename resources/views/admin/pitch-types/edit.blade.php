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
      <h1 class="m-0">CẬP NHẬT LOẠI SÂN BÓNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pitch-types.index') }}">Pitch Type</a></li>
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
      <h3 class="card-title">Cập nhật loại sân bóng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.pitch-types.update', $pitchType) }}" method="post" enctype="multipart/form-data">
      @method('patch')
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Tên loại sân *</label>
          <input type="text" name="name" value="{{ old('name') !== null ? old('name') : $pitchType->name }}" class="form-control @error('name') is-invalid @enderror" id="name">
          @error('name')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="price">Đơn giá (đ/phút) *</label>
          <input type="text" name="price" value="{{ old('price') !== null ? old('price') : $pitchType->price }}" class="form-control @error('price') is-invalid @enderror" id="price">
          @error('price')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
            <div class="row">
              <div class="col-sm-11">
                <label for="image">Hình ảnh</label><span class="text-sm"> (Nên chọn ảnh tỷ lệ 4:3)</span>
                <div class="custom-file">
                  <input type="hidden" name="old_image" value="{{ $pitchType->image }}">
                  <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image">
                  <label class="custom-file-label" for="image">Chọn hình ảnh</label>
                </div>
                @error('image')
                <span class="text-sm text-danger mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-sm-1">
                @if($pitchType->image)
                <img src="{{ asset($pitchType->image) }}" alt="$pitchType->name" with="70" height="70">
                @else
                <img src="{{ asset('backend/images/no-image.png') }}" alt="$pitchType->name" with="70" height="70">
                @endif
              </div>
            </div>
          </div>

        <div class="form-group">
          <label for="description">Mô tả</label>
          <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') !== null ? old('description') : $pitchType->description }}</textarea>
          @error('description')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
         </div>

        <div class="form-group">
            <label for="introduce">Giới thiệu</label>
            <textarea name="introduce" id="introduce" class="form-control @error('introduce') is-invalid @enderror">{{ old('introduce') !== null ? old('introduce') : $pitchType->introduce }}</textarea>
            @error('introduce')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="price">Sức chứa (người) *</label>
          <input type="text" name="capacity" value="{{ old('capacity') !== null ? old('capacity') : $pitchType->capacity }}" class="form-control @error('capacity') is-invalid @enderror" id="capacity">
          @error('capacity')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.pitch-types.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
