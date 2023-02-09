<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Hoá đơn</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body style="display: hidden">
  <h1 class="text-center m-4">Hoá Đơn Đặt Sân</h1>
  <div class="container">
    <div class="row mb-3">
      <div class="col">
        <strong>Họ tên khách hàng:</strong><span> {{ $order->customer->name }}</span>
      </div>
      <div class="col">
        <strong>Số điện thoại:</strong><span> {{ $order->customer->phone_number }}</span>
      </div>
      <div class="col">
        <strong>Ngày thanh toán:</strong><span> {{ $date }}</span>
      </div>
    </div>
    <table class="table table-bordered mb-4 text-center" style="width:100%">
      <thead class="bg-success">
        <tr>
          <th class="align-middle">Số TT</th>
          <th class="align-middle">Tên hàng hoá, sản phẩm, dịch vụ</th>
          <th class="align-middle">Đơn vị</th>
          <th class="align-middle">Số lượng</th>
          <th class="align-middle">Đơn giá</th>
          <th class="align-middle">Thành tiền</th>
        </tr>
      </thead>
      <tbody class="table-success">
        @php
        $index = 1;
        $totalMoney = 0;
        @endphp

        @php
        $pitchFee = 0;

        $ts = strtotime($order->time_start);
        $te = strtotime($order->time_end);
        $totalMinutes = date('H', $te-$ts) * 60 + date('i', $te-$ts);

        // pitch fee
        $pitchFee = $order->price * $totalMinutes;

        // total money
        $totalMoney += $pitchFee;
        @endphp
        <tr>
          <td>{{ $index++ }}</td>
          <td>{{ $order->pitch->name }}</td>
          <td>phút</td>
          <td class="text-right">{{ $totalMinutes }}</td>
          <td class="text-right">{{ number_format($order->price) }}đ</td>
          <td class="text-right">{{ number_format($pitchFee) }}đ</td>
        </tr>
        @foreach($order->orderServices as $orderService)
        @php
        $serviceFee = $orderService->quantity * $orderService->price;
        $totalMoney += $serviceFee;
        @endphp
        <tr>
          <td>{{ $index++ }}</td>
          <td>{{ $orderService->service->name }}</td>
          <td>cái</td>
          <td class="text-right">{{ $orderService->quantity }}</td>
          <td class="text-right">{{ number_format($orderService->price) }}đ</td>
          <td class="text-right">{{ number_format($serviceFee) }}đ</td>
        </tr>
        @endforeach
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right"><strong>Tổng:</strong></td>
          <td class="text-right text-success"><strong>{{ number_format($totalMoney) }}đ</strong></td>
        </tr>
      </tbody>
    </table>
    <div class="d-flex justify-content-around">
      <div class="text-center">
        <label class="d-block mb-4">Người lập đơn</label>

        <strong>{{ $order->user->name }}</strong>
      </div>
      <div class="text-center">
        <label class="d-block mb-4">Người thanh toán</label>

        <strong>{{ auth()->user()->name }}</strong>
      </div>
      <div class="text-center">
        <label class="d-block mb-4">Khách hàng</label>
        <strong>{{ $order->customer->name }}</strong>
      </div>
    </div>
  </div>
  <div class="d-print-none text-center mt-4">
    <a href="{{ route('admin.orders.index')  }}" class="btn btn-success">Hoàn thành</a>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script>
    $('document').ready(function() {
      window.print()
    })

  </script>
</body>
</html>
