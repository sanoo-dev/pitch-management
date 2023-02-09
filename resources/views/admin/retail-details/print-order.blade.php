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
  <h1 class="text-center m-4">Hoá Đơn Bán Lẻ</h1>
  <div class="container">
    <div class="row mb-3">
      <div class="col-7">
        <span>Họ tên khách hàng:</span> <strong>.......................</strong>
      </div>
      <div class="col-3">
        <span>Số điện thoại:</span> <strong>.......................</strong>
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
        @foreach($retail->retailDetails as $retailDetail)
        @php
        $serviceFee = $retailDetail->quantity * $retailDetail->price;
        $totalMoney += $serviceFee;
        @endphp
        <tr>
          <td>{{ $index++ }}</td>
          <td>{{ $retailDetail->service->name }}</td>
          <td>cái</td>
          <td class="text-right">{{ $retailDetail->quantity }}</td>
          <td class="text-right">{{ number_format($retailDetail->price) }}đ</td>
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

        <strong>{{ $retail->user->name }}</strong>
      </div>
      <div class="text-center">
        <label class="d-block mb-4">Khách hàng</label>
        <strong></strong>
      </div>
    </div>
  </div>
  <div class="d-print-none text-center mt-4">
    <a href="{{ route('admin.retails.index')  }}" class="btn btn-success">Hoàn thành</a>
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
