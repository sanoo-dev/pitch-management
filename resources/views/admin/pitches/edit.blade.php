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
      <h1 class="m-0">CẬP NHẬT SÂN BÓNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pitches.index') }}">Pitch</a></li>
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
      <h3 class="card-title">Cập nhật sân bóng</h3>
    </div>
    <form action="{{ route('admin.pitches.update', $pitch) }}" method="post" enctype="multipart/form-data">
      @method('patch')
      @csrf
      <input type="hidden" name="status" value="{{ $pitch->status }}">
      <div class="card-body">
        <div class="form-group">
          <label for="name">Tên sân bóng *</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') !== null ? old('name') : $pitch->name }}" id="name">
          @error('name')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="pitch_type_id">Loại sân bóng *</label>
          <input type="hidden" name="pitch_type_id" value="{{ $pitch->pitch_type_id }}">
          <input class="form-control" type="text" name="pitch_type_id" value="{{ $pitch->pitchType->id }}" readonly>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-sm-11">
              <label for="image">Hình ảnh</label><span class="text-sm"> (Nên chọn ảnh tỷ lệ 4:3)</span>
              <div class="custom-file">
                <input type="hidden" name="old_image" value="{{ $pitch->image }}">
                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image">
                <label class="custom-file-label" for="image">Chọn hình ảnh</label>
              </div>
              @error('image')
              <span class="text-sm text-danger mt-1">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-sm-1">
              @if($pitch->image)
              <img src="{{ asset($pitch->image) }}" alt="$pitch->name" with="70" height="70">
              @else
              <img src="{{ asset('backend/images/no-image.png') }}" alt="$pitch->name" with="70" height="70">
              @endif
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="location">Địa điểm *</label>
          <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') !== null ? old('location') : $pitch->location }}" id="location">
          @error('location')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status">Trạng thái *</label>
          <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
            <option value="1">Hoạt động</option>
            <option {{ old('status') ? (old('status') == $pitch->status ? 'selected' : '') : ($pitch->status == 0 ? 'selected' : '') }} value="0">Bảo trì</option>
            <option {{ old('status') ? (old('status') == $pitch->status ? 'selected' : '') : ($pitch->status == 2 ? 'selected' : '') }} value="2">Ngừng hoạt động</option>
          </select>
          @error('status')
          <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.pitches.index') }}" class="btn btn-default">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@endsection
