@extends('layouts.admin')

@section('title', 'Đặt dịch vụ')

@section('css')
@endsection

@section('js')
@endsection

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">ĐẶT DỊCH VỤ</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.retails.index') }}">Retail</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.retail-details.index', $retail) }}">Retail Detail</a></li>
                <li class="breadcrumb-item active">Buy</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
    @foreach($serviceTypes as $serviceType)
    @if(count($serviceType->services) > 0)
    <h3 class="text-uppercase text-red">{{ $serviceType->name }}</h3>
    <hr>

    <div class="row">
        @foreach($serviceType->services as $service)
        <div class="col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-3">
            <div class="card" style="width: auto;">
                <img class="card-img-top rounded" src="{{ $service->image != '' ? asset($service->image) : asset('backend/images/no-image-43.png') }}" alt="Card image cap">
                <div class="card-body">
                    <form action="{{ route('admin.retail-details.store', $retail) }}" method="post">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="price" value="{{ $service->price }}">
                        <h5 class="text-center">{{ $service->name }}</h5>
                        <h6 class="mb-2 text-center"><span class="badge text-lg badge-success"> kho:{{  $service->inventory  }}</span></h6>

                        <p class="mb-2 text-center"><span class="badge text-lg badge-warning">{{ number_format($service->price) }}đ</span></p>

                        <div class="row mb-2">
                            <div class="col-6">Số lượng:</div>
                            <input name="quantity" class="col-6" min="0" max="{{  $service->inventory }}" type="number" value="0">
                        </div>

                        <div class="text-center">
                            <input type="submit" class="btn btn-sm btn-primary" value="Mua">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @endforeach
</div>
@endsection
