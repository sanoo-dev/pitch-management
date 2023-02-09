@extends('layouts.admin')

@section('title', 'Dịch vụ')

@section('css')
@endsection

@section('js')
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
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}?date={{ $date }}">Booked</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.order-services.index', $order) }}?date={{ $date }}">Order Service</a></li>
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
        <div class="card-body">
            <div class="col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-3">
                <div class="card" style="width: auto;">
                    <img class="card-img-top rounded" src="{{ $orderService->service->image != '' ? asset($orderService->service->image) : asset('backend/images/no-image-43.png') }}" alt="Card image cap">
                    <div class="card-body">
                        <form action="{{ route('admin.order-services.update', [$orderService, $date]) }}" method="post">
                            @method('patch')
                            @csrf
                            <h5 class="text-center">{{ $orderService->service->name }} (Còn {{ $orderService->service->inventory }})</h5>
                            <p class="mb-3 text-center"><span class="badge text-lg badge-warning">{{ number_format($orderService->price) }}đ</span></p>

                            <div class="row mb-3">
                                <div class="col-6">Số lượng:</div>
                                <input name="quantity" class="col-6" min="0" max="{{ $orderService->service->inventory + $orderService->quantity }}" type="number" value="{{ $orderService->quantity }}">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-default">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>
@endsection
