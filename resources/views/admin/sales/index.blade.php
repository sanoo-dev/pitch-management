@extends('layouts.admin')

@section('title', 'Doanh số')

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

  $(document).ready(function() {
    $('#example2').DataTable({
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
    $('#date1, #date2').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });

</script>
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">DOANH SỐ</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active">Sales</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  <div class="mb-3">
    <form action="{{ route('admin.sales.index') }}" method="get">
      <strong>Từ ngày:</strong>
      <input type="text" name="date1" class="datetimepicker-input" data-toggle="datetimepicker" data-target="#date1" id="date1" value="{{ $date1 }}" required>
      <strong>Đến ngày:</strong>
      <input type="text" name="date2" class="datetimepicker-input" data-toggle="datetimepicker" data-target="#date2" id="date2" value="{{ $date2 }}" required>
      <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
    </form>
  </div>
  <div class="mb-3">
    <form action="{{ route('admin.sales.index') }}" method="get">
      <strong>Chọn sẵn:</strong>
      <select name="option" class="d-inline form-control form-control-sm" style="width: auto" required>
        <option value="" {{ $option ==  null ? 'selected' : '' }} disabled>-- Lọc theo chọn sẵn --</option>
        <option value="current_week" {{ $option ==  'current_week' ? 'selected' : '' }}}>Tuần này</option>
        <option value="current_month" {{ $option == 'current_month' ? 'selected' : '' }}>Tháng này</option>
        <option value="current_year" {{ $option == 'current_year' ? 'selected' : '' }}}>Năm này</option>
      </select>
      <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
    </form>
  </div>
  <hr>
  <h2 class="mt-4">Đặt sân</h2>
  <table id="example" class="table table-bordered table-striped text-center mt-3" style="width:100%">
    <thead class="bg-success">
      <th class="align-middle">Số TT</th>
      <th class="align-middle">Ngày</th>
      <th class="align-middle">Tổng đơn</th>
      <th class="align-middle">Tổng doanh thu</th>
    </thead>
    <tbody class="table-success">
      @php
      $index = 1;
      $totalMoney = 0;
      $totalOrder = 0;

        function getPitchFee($timeStart, $timeEnd, $price, $breakTime = null) {
            $orderDate = date('Y-m-d', strtotime($timeStart));
            $pFee = 0;
            if ($breakTime) {
                $hourStart = date('H', strtotime($timeStart));
                $hourEnd = date('H', strtotime($timeEnd));

                $breakDateTime = date('Y-m-d H:i:s', strtotime($orderDate . ' ' . $breakTime));
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
      @foreach ($sales as $date => $sale)
      @php
      $totalOrderByDate = count($sale);
      $totalMoneyByDate = 0;
      foreach ($sale as $order) {
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
      $totalMoneyByDate += $pitchFee + $serviceFee;
      }
      $totalOrder += $totalOrderByDate;
      $totalMoney += $totalMoneyByDate;
      @endphp
      <tr>
        <td style="width:80px">{{ $index++ }}</td>
        <td>{{ date('Y-m-d', strtotime($date)) }}</td>
        <td class="text-right">{{ $totalOrderByDate }}</td>
        <td class="text-right">{{ number_format($totalMoneyByDate) }}đ</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td class="text-right"><strong>Tổng:</strong></td>
        <td class="text-right"><strong>{{ $totalOrder }}</strong></td>
        <td class="text-right text-primary"><strong>{{ number_format($totalMoney) }}đ</strong></td>
      </tr>
    </tfoot>
  </table>
  <hr>
  <br>
  <h2 class="mt-4">Bán lẻ</h2>
  <table id="example2" class="table table-bordered table-striped text-center mt-3" style="width:100%">
    <thead class="bg-warning">
      <th class="align-middle">Số TT</th>
      <th class="align-middle">Ngày</th>
      <th class="align-middle">Tổng đơn</th>
      <th class="align-middle">Tổng doanh thu</th>
    </thead>
    <tbody class="table-success">
      @php
      $index = 1;
      $totalMoneyRetail = 0;
      $totalOrderRetail = 0;
      @endphp
      @foreach ($saleRetails as $dateRetail => $saleRetail)
      @php
      $totalOrderRetailByDate = count($saleRetail);
      $totalMoneyRetailByDate = 0;
      foreach ($saleRetail as $retail) {
      $serviceFee = 0;

      // service fee
      foreach ($retail->retailDetails as $retailDetail) {
      $serviceFee += $retailDetail->quantity * $retailDetail->price;
      }
      $totalMoneyRetailByDate += $serviceFee;
      }
      $totalOrderRetail += $totalOrderRetailByDate;
      $totalMoneyRetail += $totalMoneyRetailByDate;
      @endphp
      <tr>
        <td style="width:80px">{{ $index++ }}</td>
        <td>{{ date('Y-m-d', strtotime($dateRetail)) }}</td>
        <td class="text-right">{{ $totalOrderRetailByDate }}</td>
        <td class="text-right">{{ number_format($totalMoneyRetailByDate) }}đ</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td class="text-right"><strong>Tổng:</strong></td>
        <td class="text-right"><strong>{{ $totalOrderRetail }}</strong></td>
        <td class="text-right text-primary"><strong>{{ number_format($totalMoneyRetail) }}đ</strong></td>
      </tr>
    </tfoot>
  </table>
  <hr>
  <br>
  <div class="row mt-4">
    <div class="col-sm-6">
      <h4 class="text-center mb-3">Top khách hàng đặt sân nhiều nhất</h4>
      <table class="table table-bordered table-striped text-center">
        <thead class="bg-danger">
          <th class="align-middle">Top</th>
          <th class="align-middle">Tên KH</th>
          <th class="align-middle">Tổng đơn</th>
        </thead>
        <tbody class="table-success">
          @php
          $index = 1;
          @endphp
          @foreach ($rankCustomers as $customer)
          <tr>
            <td>{{ $index++ }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->times_booked }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="col-sm-6">
      <h4 class="text-center mb-3">Top loại sân được đặt nhiều nhất</h4>
      <table class="table table-bordered table-striped text-center">
        <thead class="bg-purple">
          <th class="align-middle">Top</th>
          <th class="align-middle">Tên loại sân</th>
          <th class="align-middle">Tổng đơn</th>
        </thead>
        <tbody class="table-success">
          @php
          $index = 1;
          @endphp
          @foreach ($rankPitchTypes as $rankPitchType)
          <tr>
            <td>{{ $index++ }}</td>
            <td>{{ $rankPitchType->pitchType->name }}</td>
            <td>{{ $rankPitchType->count_order }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
