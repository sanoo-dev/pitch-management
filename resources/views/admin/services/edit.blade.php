@extends('layouts.admin')

@section('title', 'Dịch vụ')

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
            <h1 class="m-0">CẬP NHẬT DỊCH VỤ</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Service</a></li>
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
            <h3 class="card-title">Cập nhật dịch vụ</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.services.update', $service) }}" method="post" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="service_type_id">Loại dịch vụ *</label>
                    <select name="service_type_id" class="form-control @error('service_type_id') is-invalid @enderror" id="service_type_id">
                        <option selected disabled>-- Chọn loại dịch vụ --</option>
                        @foreach($serviceTypes as $serviceType)
                        <option @if(old('service_type_id') !==null) {{ old('service_type_id') == $serviceType->id ? 'selected' : '' }} @else {{ $service->serviceType->id == $serviceType->id ? 'selected' : '' }} @endif value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
                        @endforeach
                    </select>
                    @error('service_type_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Tên dịch vụ *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') !== null ? old('name') : $service->name }}" id="name">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-11">
                            <label for="image">Hình ảnh</label><span class="text-sm"> (Nên chọn ảnh vuông)</span>
                            <div class="custom-file">
                                <input type="hidden" name="old_image" value="{{ $service->image }}">
                                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image">
                                <label class="custom-file-label" for="image">Chọn hình ảnh</label>
                            </div>
                            @error('image')
                            <span class="text-sm text-danger mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-1">
                            @if($service->image)
                            <img src="{{ asset($service->image) }}" alt="$service->name" with="70" height="70">
                            @else
                            <img src="{{ asset('backend/images/no-image.png') }}" alt="$service->name" with="70" height="70">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price">Giá tiền (VND/Đơn vị) *</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') !== null ? old('price') : $service->price }}" id="price">
                    @error('price')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inventory">Số lượng *</label>
                    <input type="text" name="inventory" class="form-control @error('inventory') is-invalid @enderror" value="{{ old('inventory') !== null ? old('inventory') : $service->inventory }}" id="inventory">
                    @error('inventory')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Tình trạng *</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                      <option value="1">Đang bán</option>
                      <option {{ old('status') ? (old('status') === 0 ? 'selected' : '') : ($service->status === 0 ? 'selected' : '')  }} value="0">Ngừng bán</option>
                    </select>
                    @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-default">Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
