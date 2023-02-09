@extends('layouts.admin')

@section('title', 'Loại dịch vụ')

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
            <h1 class="m-0">DANH SÁCH LOẠI DỊCH VỤ</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                <li class="breadcrumb-item active">Service Type</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div class="container-fluid">
    @can('Thêm loại dịch vụ')
    <a href="{{ route('admin.service-types.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i></a>
    @endcan
    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
        <thead class="bg-success">
            <tr>
                <th class="align-middle">Tên loại dịch vụ</th>
                <th class="align-middle" width="100">
                    Chức năng
                </th>
            </tr>
        </thead>
        <tbody class="table-success">
            @foreach($serviceTypes as $serviceType)
            <tr>
                <td>{{ $serviceType->name }}</td>
                <td>
                    <form action="{{ route('admin.service-types.destroy', $serviceType) }}" method="post" class="text-center">
                    @method('delete')
                    @csrf
                        @can('Sửa loại dịch vụ')
                        <a href="{{ route('admin.service-types.edit', $serviceType) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                        @endcan

                        @can('Xoá loại dịch vụ')
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
