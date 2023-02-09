@extends('layouts.admin')

@section('title', 'Danh sách sân đã đặt')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable({
      "language": {
        "lengthMenu": "Hiển thị _MENU_ bản ghi trên một trang"
        , "zeroRecords": "Không tìm thấy kết quả"
        , "info": "Hiển thị trang _PAGE_ của _PAGES_"
        , "infoEmpty": "Danh sách rỗng"
        , "infoFiltered": "(lọc từ _MAX_ tổng số bản ghi)"
      }
    });
  });

</script>
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
      <h1 class="m-0">DANH SÁCH SÂN ĐÃ ĐẶT</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active">Booked</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  <div class="d-flex justify-content-center mb-3" style="margin-bottom: -0rem !important;">
    <div style="margin-left:-44px">
      <form action="{{ route('admin.orders.index') }}" method="get">
        <strong>Chọn ngày:</strong>
        <input type="text" name="date" class="datetimepicker-input" data-toggle="datetimepicker" data-target="#date" id="date" value="{{ $date }}" required>
        <button type="submit" class="btn btn-sm btn-primary" style="margin-top: -5px;">Duyệt</button>
      </form>
    </div>
    <a style="margin: 0 50px" href="{{ route('admin.pitch-booking-status.index') }}?date={{ $date }}" class="btn btn-sm btn-success">Xem tình
      trạng đặt sân</a>
  </div>
  <table id="example" class="table table-bordered text-center" style="width:100%">
    <thead class="bg-success">
        <th class="align-middle">Tên KH</th>
        <th class="align-middle">SĐT</th>
        <th class="align-middle">Nhân viên lập đơn</th>
        <th class="align-middle">Sân</th>
        <th class="align-middle">Vào sân</th>
        <th class="align-middle">Ra sân</th>
        {{--  <th class="align-middle">Phút</th>  --}}
        <th class="align-middle">Tiền sân</th>
        <th class="align-middle">Tiền DV</th>
        <th class="align-middle">Thành tiền</th>
        <th class="align-middle">Tình trạng</th>
        <th class="align-middle">Thanh toán</th>
        <th class="align-middle">Chức năng</th>
    </thead>
    <tbody class="table-success">
      @php
      $totalMoney = 0;
      $payedMoney = 0;

        function getPitchFee($timeStart, $timeEnd, $price, $breakTime = null) {
            $orderDate = date('Y-m-d', strtotime($timeStart));
            $pFee = 0;
            if ($breakTime) {
                $hourStart = date('H', strtotime($timeStart));
                $hourEnd = date('H', strtotime($timeEnd));

                $breakDateTime = date('Y-m-d H:i:s', strtotime($orderDate . ' ' . $breakTime)); // 2022-06-15 15:00:00
                $pFee += getTotalMinutes($timeStart, $breakDateTime) * getPrice($timeStart, $price);
                $pFee += getTotalMinutes($breakDateTime, $timeEnd) * getPrice($timeEnd, $price);
            } else {
                $pFee += getTotalMinutes($timeStart, $timeEnd) * getPrice($timeStart, $price);
            }
            return $pFee;
        }

        function getPrice($dateTime, $price) {
            $hour = date('H', strtotime($dateTime));
            $weekend =  date('D', strtotime($dateTime));

            if ($weekend === 'Sat' || $weekend === 'Sun') {
                if ($hour >= 5 && $hour < 9) {
                    return $price *= 1;
                }
                if($hour >= 9 && $hour < 15){
                    return $price *= 0.8;
                }
                if($hour >= 15 && $hour < 18){
                    return $price *= 1.6;
                }
                if($hour >= 18 && $hour < 23){
                    return $price *= 2.2;
                }
                else {
                    return $price *= 1.6;
                }
            } else {
                if ($hour >= 5 && $hour < 9) {
                    return $price *= 1;
                }
                if($hour >= 9 && $hour < 15){
                    return $price *= 0.8;
                }
                if($hour >= 15 && $hour < 18){
                    return $price *= 1.4;
                }
                if($hour >= 18 && $hour < 23){
                    return $price *= 2;
                }
                else {
                    return $price *= 1.6;
                }
            }

        }

        function getTotalMinutes($timeStart, $timeEnd) {
            $ts = strtotime($timeStart);
            $te = strtotime($timeEnd);
            return date('H', $te-$ts) * 60 + date('i', $te-$ts);
        }
      @endphp
      @foreach($orders as $order)
      @php
        $pitchFee = 0;
        $serviceFee = 0;

        $orderHourStart = date('H', strtotime($order->time_start));
        $orderHourEnd = date('H', strtotime($order->time_end));

        if ($orderHourStart >= 5 && $orderHourStart < 9) {
            if ($orderHourEnd > 9) {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price, '09:00:00');
            } else {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else if ($orderHourStart >= 9 && $orderHourStart < 15) {
            if ($orderHourEnd > 15) {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price, '15:00:00');
            } else {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else if ($orderHourStart >= 15 && $orderHourStart < 18) {
            if ($orderHourEnd > 18) {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price, '18:00:00');
            } else {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else if ($orderHourStart >= 18 && $orderHourStart < 23) {
            if ($orderHourEnd > 23) {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price, '23:00:00');
            } else {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else {
            if ($orderHourEnd > 5) {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price, '05:00:00');
            } else {
                $pitchFee = getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        }

        $totalMinutes = getTotalMinutes($order->time_start, $order->time_end);

      // service fee
      foreach ($order->orderServices as $orderService) {
      $serviceFee += $orderService->quantity * $orderService->price;
      }

      $intoMoney = $pitchFee + $serviceFee;

      // total money
      $totalMoney += $intoMoney;

      // payed money
      if ($order->pay_status == 1) {
      $payedMoney += $intoMoney;
      }
      @endphp
      <tr>
        <td>{{ $order->customer->name }}</td>
        <td>{{ $order->customer->phone_number }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->pitch->name }}</td>
        <td>{{ date('H:i', strtotime($order->time_start)) }}</td>
        <td>{{ date('H:i', strtotime($order->time_end)) }}</td>
        {{--  <td>{{ $totalMinutes }}</td>  --}}
        <td class="text-right">{{ number_format($pitchFee) }}đ</td>
        <td class="text-right">{{ number_format($serviceFee) }}đ</td>
        <td class="text-right text-red"><strong>{{ number_format($intoMoney) }}đ</strong></td>
        <td class="text-center">
          @if ($order->pay_status == 0)
          <span class="badge badge-danger">Chưa thanh toán</span>
          @elseif ($order->pay_status == 1)
          <span class="badge badge-success">Đã thanh toán</span>
          @else
          <span class="badge badge-warning">Đợi nhận sân</span>
          @endif
        </td>
        <td>
            @if ($order->pay_status != 2)
                @can('Thanh toán hoá đơn đặt sân')
                <form action="{{ route('admin.orders.pay', $order) }}" method="post" class="text-center">
                  @csrf
                  <button onclick="return confirm('Tiến hành thanh toán?')" type="submit" class="btn btn-sm btn-success" @if($order->pay_status == 1) disabled @endif><i class="far fa-money-bill-alt"></i></button>
                </form>
                @endcan
            @else
                @can('Thanh toán hoá đơn đặt sân')
                <form action="{{ route('admin.orders.take', $order) }}" method="post" class="text-center">
                  @csrf
                  <button onclick="return confirm('Tiến hành nhận sân?')" type="submit" class="btn btn-sm btn-info"><i class="fas fa-handshake"></i></button>
                </form>
                @endcan
            @endif
        </td>
        <td>
          <form action="{{ route('admin.orders.destroy', $order) }}" method="post" class="text-center">
            @csrf
            @method('delete')
            @can('Thêm dịch vụ hoá đơn đặt sân')
            <a @if($order->pay_status ==2) role="link" aria-disabled="true" class="btn btn-sm btn-primary disabled"@else href="{{ route('admin.order-services.index', $order) }}?date={{ $date }}" class="btn btn-sm btn-primary" @endif><i class="fas fa-shopping-cart"></i></a>
            @endcan
            @can('Sửa hoá đơn đặt sân')
            <a @if($order->pay_status ==1) role="link" aria-disabled="true" class="btn btn-sm btn-warning disabled"@else href="{{ route('admin.orders.edit', [$order, $date]) }}" class="btn btn-sm btn-warning" @endif ><i class="fas fa-pen"></i></a>
            @endcan
            @can('Xóa hoá đơn đặt sân')
            <button onclick="return confirm('Chắc chắn muốn xoá đơn?')" type="submit" class="btn btn-sm btn-danger" @if($order->pay_status !=2) disabled @endif><i class="fas fa-trash"></i></button>
            @endcan
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot class="table-success">
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right"><strong>Đã thanh toán:</strong></td>
          <td class="text-right text-success"><strong>{{ number_format($payedMoney) }}đ</strong></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right"><strong>Chưa thanh toán:</strong></td>
          <td class="text-right text-warning"><strong>{{ number_format($totalMoney - $payedMoney) }}đ</strong></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right"><strong>Tổng tiền:</strong></td>
          <td class="text-right text-primary"><strong>{{ number_format($totalMoney) }}đ</strong></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
    </tfoot>
  </table>
</div>
@endsection
