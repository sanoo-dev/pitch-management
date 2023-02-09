<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('admin.index') }}" class="brand-link" style="text-align: center">
    {{--  <img src="{{ asset('backend/dist/img/download.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">  --}}
    <span class="brand-text font-weight-light">QUẢN LÝ SÂN BÓNG</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('backend/dist/img/avatar4.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('admin.users.show', auth()->user()) }}" class="img-circle elevation-d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <!-- Nav item -->
        @can('Xem bảng điều khiển')
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Bảng điều khiển
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tổng quan</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('admin.sales.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Doanh số</p>
              </a>
            </li>
          </ul>
        </li>
        <hr width="45%" align="center" color="#5071C7" />
        @endcan

        @can('Xem hoá đơn đặt sân')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="{{ route('admin.pitch-booking-status.index') }}" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Tình trạng sân</p>
          </a>
        </li>

        <!-- Nav item -->
        <li class="nav-item">
          <a href="{{ route('admin.orders.index') }}" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Danh sách đơn đặt sân</p>
          </a>
        </li>
        @endcan

        @can('Xem hoá đơn bán lẻ')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="{{ route('admin.retails.index') }}" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Bán lẻ</p>
          </a>
        </li>
        @endcan

        @can('Xem khách hàng')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fab fa-accessible-icon"></i>
            <p>
              Khách hàng
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('Thêm khách hàng')
            <li class="nav-item">
              <a href="{{ route('admin.customers.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm mới</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="{{ route('admin.customers.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
          </ul>
        </li>
        <hr width="45%" align="center" color="#5071C7" />
        @endcan

        @can('Xem loại sân bóng')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-baseball-ball"></i>
            <p>
              Loại sân bóng
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('Thêm loại sân bóng')
            <li class="nav-item">
              <a href="{{ route('admin.pitch-types.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm mới</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="{{ route('admin.pitch-types.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        @can('Xem loại dịch vụ')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-pizza-slice"></i>
            <p>
              Loại dịch vụ
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('Thêm loại dịch vụ')
            <li class="nav-item">
              <a href="{{ route('admin.service-types.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm mới</p>
              </a>
            </li>
            @endcan

            <li class="nav-item">
              <a href="{{ route('admin.service-types.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan


        @can('Xem sân bóng')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-baseball-ball"></i>
            <p>
              Sân bóng
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('Thêm sân bóng')
            <li class="nav-item">
              <a href="{{ route('admin.pitches.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm mới</p>
              </a>
            </li>
            @endcan

            <li class="nav-item">
              <a href="{{ route('admin.pitches.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        @can('Xem dịch vụ')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-hamburger"></i>
            <p>
              Dịch vụ
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('Thêm dịch vụ')
            <li class="nav-item">
              <a href="{{ route('admin.services.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm mới</p>
              </a>
            </li>
            @endcan

            <li class="nav-item">
              <a href="{{ route('admin.services.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        @can('Xem quy định')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-gavel"></i>
            <p>
              Quy định
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('Thêm quy định')
            <li class="nav-item">
              <a href="{{ route('admin.regulations.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm mới</p>
              </a>
            </li>
            @endcan

            <li class="nav-item">
              <a href="{{ route('admin.regulations.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        <!-- Nav item -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>
              Phân quyền
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('Xem người dùng')
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách người dùng</p>
              </a>
            </li>
            @endcan

            @can('Xem vai trò')
            <li class="nav-item">
              <a href="{{ route('admin.roles.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh sách vai trò</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>

        @can('Xem cài đặt')
        <!-- Nav item -->
        <li class="nav-item">
          <a href="{{ route('admin.settings.index') }}" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Cài đặt</p>
          </a>
        </li>
        @endcan

        <!-- Nav item -->
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Đăng xuất</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
