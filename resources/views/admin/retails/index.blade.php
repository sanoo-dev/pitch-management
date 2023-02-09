@extends('layouts.admin')

@section('title', 'Bán lẻ')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script>
    $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
        icons: {
            time: 'fas fa-clock'
            , date: 'fas fa-calendar'
            , up: 'fas fa-arrow-up'
            , down: 'fas fa-arrow-down'
            , previous: 'fas fa-chevron-left'
            , next: 'fas fa-chevron-right'
            , today: 'fas fa-calendar-check-o'
            , clear: 'fas fa-trash'
            , close: 'fas fa-times'
        }
    });

    $(function() {
        $('#date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });

</script>
@endsection

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">BÁN LẺ</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item active">Retail</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <div>
            <form action="{{ route('admin.retails.index') }}" method="get">
                <strong>Chọn ngày:</strong>
                <input type="text" name="date" class="datetimepicker-input" data-toggle="datetimepicker" data-target="#date" id="date" value="{{ $date }}" required>
                <button type="submit" class="btn btn-sm btn-primary">Duyệt</button>
            </form>
        </div>
        @can('Thêm hoá đơn bán lẻ')
        <a href="{{ route('admin.retails.create') }}" class="btn btn-sm btn-success">Tạo đơn mới</a>
        @endcan
    </div>
    <table class="table table-bordered text-center" style="width:100%">
        <thead class="bg-success">
            <tr>
                <th class="align-middle">Mã đơn hàng</th>
                <th class="align-middle">Thành tiền</th>
                <th class="align-middle">Chức năng</th>
            </tr>
        </thead>
        <tbody class="table-success">
            @php
            $totalMoney = 0;
            $payedMoney = 0;
            @endphp
            @foreach($retails as $retail)
            @php
            $intoMoney = 0;
            foreach ($retail->retailDetails as $retailDetail) {
            $intoMoney += $retailDetail->quantity * $retailDetail->price;
            }
            // total money
            $totalMoney += $intoMoney;
            @endphp
            <tr>
                <td>{{ $retail->id }}</td>
                <td class="text-right text-red"><strong>{{ number_format($intoMoney) }}đ</strong></td>
                <td>
                    <form action="{{ route('admin.retails.destroy', $retail) }}" method="post" class="text-center">
                        @csrf
                        @method('delete')
                        @can('Thêm hoá đơn bán lẻ')
                        <a href="{{ route('admin.retail-details.index', $retail) }}" class="btn btn-sm btn-primary"><i class="fas fa-shopping-cart"></i></a>
                        @endcan
                        @can('Xóa hoá đơn bán lẻ')
                        <button onclick="return confirm('Chắc chắn muốn xoá đơn?')" type="submit" class="btn btn-sm btn-danger" @if($retail->pay_status == 1) disabled @endif><i class="fas fa-trash"></i></button>
                        @endcan
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td class="text-right"><strong>Tổng tiền:</strong></td>
                <td class="text-right text-primary"><strong>{{ number_format($totalMoney) }}đ</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
