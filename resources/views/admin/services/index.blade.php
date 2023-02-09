@extends('layouts.admin')

@section('title', 'Dịch vụ')

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
      <h1 class="m-0">DANH SÁCH DỊCH VỤ</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active">Service</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  @can('Thêm dịch vụ')
  <a href="{{ route('admin.services.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i></a>
  @endcan
  <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
    <thead class="bg-success">
      <tr>
        <th class="align-middle" width="100">Hình ảnh</th>
        <th class="align-middle">Loại dịch vụ</th>
        <th class="align-middle">Tên dịch vụ</th>
        <th class="align-middle">Giá tiền</th>
        <th class="align-middle">Tồn kho</th>
        <th class="align-middle">Trạng thái</th>
        <th class="align-middle" width="100">
          Chức năng
        </th>
      </tr>
    </thead>
    <tbody class="table-success">
      @foreach($services as $service)
      <tr>
        <td class="text-center">
          @if($service->image)
          <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" class="rounded" with="100" height="100">
          @else
          <img src="{{ asset('backend/images/no-image.png') }}" alt="{{ $service->name }}" class="rounded" with="100" height="100">
          @endif
        </td>
        <td class="align-middle">{{ $service->serviceType->name }}</td>
        <td class="align-middle">{{ $service->name }}</td>
        <td class="text-right align-middle">{{ number_format($service->price) }} đ</td>
        <td class="text-right align-middle">{{ $service->inventory }}</td>
        <td class="align-middle">
          @if ($service->status === 0)
          <span class="badge badge-warning">Ngừng bán</span>
          @else
          <span class="badge badge-success">Đang bán</span>
          @endif
        </td>
        <td class="align-middle">
          <form action="{{ route('admin.services.destroy', $service) }}" method="post" class="text-center">
            @method('delete')
            @csrf
            @can('Sửa dịch vụ')
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            @endcan

            @can('Xoá dịch vụ')
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
