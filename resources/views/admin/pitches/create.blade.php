@extends('layouts.admin')

@section('title', 'Sân bóng')

@section('css')
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })

</script>
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">THÊM SÂN BÓNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pitches.index') }}">Pitch</a></li>
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
      <h3 class="card-title">Thêm sân bóng</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.pitches.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="status" value="0">
      <div class="card-body">
        <div class="form-group">
          <label for="name">Tên sân bóng *</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
          @error('name')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="pitch_type_id">Loại sân bóng *</label>
          <select name="pitch_type_id" class="form-control @error('pitch_type_id') is-invalid @enderror" id="pitch_type_id">
            <option selected disabled>-- Chọn loại sân bóng --</option>
            @foreach($pitchTypes as $pitchType)
            <option {{ old('pitch_type_id') == $pitchType->id ? 'selected' : '' }} value="{{ $pitchType->id }}">{{ $pitchType->name }}</option>
            @endforeach
          </select>
          @error('pitch_type_id')
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
          <label for="location">Địa điểm *</label>
          <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" id="location">
          @error('location')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status">Tình trạng *</label>
          <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
            <option value="1">Hoạt động</option>
            <option {{ old('status') === 0 ? 'selected' : '' }} value="0">Bảo trì</option>
          </select>
          @error('status')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('admin.pitches.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
