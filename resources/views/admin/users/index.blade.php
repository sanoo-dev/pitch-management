@extends('layouts.admin')

@section('title', 'Người dùng')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.3/dist/sweetalert2.min.css">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.3/dist/sweetalert2.all.min.js"></script>

<script>
  let Toast = Swal.mixin({
    toast: true
    , position: 'top-right'
    , showConfirmButton: false
    , timer: 3000
  , });
  @if(Session::has('message'))
  var type = "{{ Session::get('alert-type') }}"
  var message = "{{ Session::get('message') }}"
  switch (type) {
    case 'info':
      Swal.fire({
        title: 'Thông tin'
        , text: message
        , icon: type
        , confirmButtonText: 'OK'
      })
      break
    case 'success':
      Swal.fire({
        title: 'Thành công'
        , text: message
        , icon: type
        , confirmButtonText: 'OK'
      })
      break
    case 'warning':
      Swal.fire({
        title: 'Cảnh báo'
        , text: message
        , icon: type
        , confirmButtonText: 'OK'
      })
      break
    case 'error':
      Swal.fire({
        title: 'Xảy ra lỗi'
        , text: message
        , icon: type
        , confirmButtonText: 'OK'
      })
      break
  }
  @endif

</script>

@endsection

@section('content-header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">DANH SÁCH NGƯỜI DÙNG</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="breadcrumb-item active">User</li>
      </ol>
    </div>
  </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
  @can('Thêm người dùng')
  <a href="{{ route('admin.users.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i></a>
  @endcan
  <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
    <thead class="bg-success">
      <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Vai trò</th>
        <th>Hoạt động</th>
        <th width="100">
          Chức năng
        </th>
      </tr>
    </thead>
    <tbody class="table-success">
      @foreach($users as $user)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
          @if(!empty($user->getRoleNames()))
          @foreach($user->getRoleNames() as $v)
          <label class="badge badge-success">{{ $v }}</label>
          @endforeach
          @endif
        </td>
        <td>
          @if($user->active === 1)
          <i class="far fa-check-circle text-success"></i>
          @else
          <i class="far fa-times-circle text-danger"></i>
          @endif

        </td>
        <td>
          <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" class="text-center">
            @method('delete')
            @csrf
            @can('Sửa người dùng')
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
            @endcan

            @can('Xoá người dùng')
            <button onclick="return confirm('Chắc chắn muốn xoá? Xoá sẽ mất dữ liệu liên quan trong hoá đơn và không thể khôi phục!')" type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
            @endcan
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
