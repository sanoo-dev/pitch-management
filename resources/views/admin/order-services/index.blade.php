@extends('layouts.admin')

@section('title', 'Đặt dịch vụ')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">DANH SÁCH DỊCH VỤ | {{ $order->pitch->name }}</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.orders.index') }}?date={{ $date }}">Booked</a></li>
        <li class="breadcrumb-item active">Order Service</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  @can('Thêm dịch vụ hoá đơn đặt sân')
  <a @if($order->pay_status == 1 || $order->pay_status == 2) role="link" aria-disabled="true" class="btn btn-sm btn-success mb-3 float-right disabled"@else href="{{ route('admin.order-services.create', $order) }}?date={{ $date }}" class="btn btn-sm btn-success mb-3 float-right" @endif><i class="fas fa-shopping-cart"></i></a>
  @endcan
  <table id="example" class="table table-bordered text-center" style="width:100%">
    <thead class="bg-success">
      <tr>
        <th class="align-middle">Tên dịch vụ</th>
        <th class="align-middle">Số lượng</th>
        <th class="align-middle">Đơn giá (đ)</th>
        <th class="align-middle">Thành tiền</th>
        <th class="align-middle" width="100">
          Chức năng
        </th>
      </tr>
    </thead>
    <tbody class="table-success">
      @php
        $totalMoney = 0;
      @endphp

      @foreach($order->orderServices as $orderService)

        @php
            // into money
            $intoMoney = $orderService->quantity * $orderService->price;

            // total money
            $totalMoney += $intoMoney;
        @endphp

        <tr>
            <td>{{ $orderService->service->name }}</td>
            <td class="text-right">{{ $orderService->quantity }}</td>
            <td class="text-right">{{ number_format($orderService->price) }} đ</td>
            <td class="text-right text-red"><strong>{{ number_format($intoMoney) }}đ</strong></td>
            <td>
            @can('Sửa dịch vụ hoá đơn đặt sân')
            <form action="{{ route('admin.order-services.destroy', $orderService) }}" method="post" class="text-center">
                @method('delete')
                @csrf
                <a @if($order->pay_status == 1 || $order->pay_status == 2) role="link" aria-disabled="true" class="btn btn-sm btn-primary disabled" @else href="{{ route('admin.order-services.edit', [$order, $orderService]) }}?date={{ $date }}" class="btn btn-sm btn-primary" @endif><i class="fas fa-edit"></i></a>
                <button onclick="return confirm('Chắc chắn muốn xoá?')" type="submit" class="btn btn-sm btn-danger" {{ ($order->pay_status == 1 || $order->pay_status == 2)  ? 'disabled' : '' }}><i class="fas fa-trash-alt"></i></button>
            </form>
            @endcan
            </td>
        </tr>
      @endforeach
      <tr>
        <td></td>
        <td></td>
        <td class="text-right"><strong>Tổng tiền:</strong></td>
        <td class="text-right text-primary"><strong>{{ number_format($totalMoney) }}đ</strong></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>
@endsection
