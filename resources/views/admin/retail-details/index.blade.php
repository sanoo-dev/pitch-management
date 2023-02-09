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
            <h1 class="m-0">DANH SÁCH DỊCH VỤ | MÃ HOÁ ĐƠN: {{ $retail->id }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.retails.index') }}">Retail</a></li>
                <li class="breadcrumb-item active">Retail Detail</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
    @can('Thêm hoá đơn bán lẻ')
    <a @if($retail->pay_status == 1) role="link" aria-disabled="true" class="btn btn-sm btn-success mb-3 float-right disabled" @else href="{{ route('admin.retail-details.create', $retail) }}" class="btn btn-sm btn-success mb-3 float-right" @endif><i class="fas fa-shopping-cart"></i></a>
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
            @foreach($retail->retailDetails as $retailDetail)
            @php
            // into money
            $intoMoney = $retailDetail->quantity * $retailDetail->price;

            // total money
            $totalMoney += $intoMoney;
            @endphp

            <tr>
                <td>{{ $retailDetail->service->name }}</td>
                <td class="text-right">{{ $retailDetail->quantity }}</td>
                <td class="text-right">{{ number_format($retailDetail->price) }}đ</td>
                <td class="text-right text-red"><strong>{{ number_format($intoMoney) }}đ</strong></td>
                <td>
                    <form action="{{ route('admin.retail-details.destroy', $retailDetail) }}" method="post" class="text-center">
                        @method('delete')
                        @csrf
                        @can('Sửa hoá đơn bán lẻ')
                        <a @if($retail->pay_status == 1) role="link" aria-disabled="true" class="btn btn-sm btn-primary disabled" @else href="{{ route('admin.retail-details.edit', [$retail, $retailDetail]) }}" class="btn btn-sm btn-primary" @endif><i class="fas fa-edit"></i></a>
                        @endcan
                        @can('Xóa hoá đơn bán lẻ')
                        <button onclick="return confirm('Chắc chắn muốn xoá?')" type="submit" class="btn btn-sm btn-danger" {{ $retail->pay_status == 1 ? 'disabled' : '' }}><i class="fas fa-trash-alt"></i></button>
                        @endcan
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td class="text-right"><strong>Tổng tiền:</strong></td>
                <td class="text-right text-primary"><strong>{{ number_format($totalMoney) }}đ</strong></td>
                <td>
                    @can('Thanh toán hoá đơn bán lẻ')
                    <form action="{{ route('admin.retails.pay', $retail) }}" method="post" class="text-center">
                        @method('patch')
                        @csrf
                        <button onclick="return confirm('Tiến hành thanh toán?')" type="submit" class="btn btn-sm btn-success" {{ $retail->pay_status == 1 ? 'disabled' : '' }}>{{ $retail->pay_status == 1 ? 'Đã thanh toán' : 'Thanh toán' }}</button>
                    </form>
                    @endcan
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
