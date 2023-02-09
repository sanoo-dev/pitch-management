@extends('layouts.admin')

@section('title', 'Khách hàng')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
@endsection

@section('js')
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
@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">DANH SÁCH KHÁCH HÀNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active">Customer</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  @can('Thêm khách hàng')
  <a href="{{ route('admin.customers.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i></a>
  @endcan
  <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
    <thead class="bg-success">
      <tr>
        <th class="align-middle">Tên khách hàng</th>
        <th class="align-middle">Số điện thoại</th>
        <th class="align-middle">Thứ hạng</th>
        <th class="align-middle" width="100">
          Chức năng
        </th>
      </tr>
    </thead>
    <tbody class="table-success">
      @foreach($customers as $customer)
      <tr>
        <td>{{ $customer->name }}</td>
        <td class="text-center">{{ $customer->phone_number }}</td>
        <td class="text-center">
            @if ($customer->times_booked >= 30)
                <span class="badge badge-primary">Kim cương</span>
            @elseif ($customer->times_booked >= 20)
                <span class="badge badge-warning">Vàng</span>
            @elseif ($customer->times_booked >= 10)
                <span class="badge badge-secondary">Bạc</span>
            @elseif ($customer->times_booked >= 0)
                <span class="badge badge-danger">Đồng</span>
            @endif
        </td>
        <td>
          <form action="{{ route('admin.customers.destroy', $customer) }}" method="post" class="text-center">
            @method('delete')
            @csrf
            @can('Sửa khách hàng')
            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            @endcan

            @can('Xoá khách hàng')
            <button onclick="return confirm('Chắc chắn muốn xoá?')" type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
            @endcan
          </form>
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
</div>
@endsection
