 class="bg-success"@extends('layouts.admin')

 @section('title', 'Quy định')

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
             <h1 class="m-0">DANH SÁCH QUY ĐỊNH</h1>
         </div>
         <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
                 <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                 <li class="breadcrumb-item active">Regulation</li>
             </ol>
         </div>
     </div>
 </div>
 @endsection

 @section('main-content')
 <div class="container-fluid">
     @can('Thêm quy định')
     <a href="{{ route('admin.regulations.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i></a>
     @endcan
     <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
         <thead class="bg-success text-center">
             <tr>
                 <th class="align-middle">Tên quy định</th>
                 <th class="align-middle">Mô tả</th>
                 <th class="align-middle" width="100">
                     Chức năng
                 </th>
             </tr>
         </thead>
         <tbody class="table-success">
             @foreach($regulations as $regulation)
             <tr>
                 <td>{{ $regulation->name }}</td>
                 <td>{!! $regulation->description !!}</td>
                 <td>
                     <form action="{{ route('admin.regulations.destroy', $regulation) }}" method="post" class="text-center">
                         @method('delete')
                         @csrf
                         @can('Sửa quy định')
                         <a href="{{ route('admin.regulations.edit', $regulation) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                         @endcan

                         @can('Xoá quy định')
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
