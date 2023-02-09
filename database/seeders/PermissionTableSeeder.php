<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Xem vai trò',
            'Thêm vai trò',
            'Sửa vai trò',
            'Xoá vai trò',

            'Xem người dùng',
            'Thêm người dùng',
            'Sửa người dùng',
            'Xoá người dùng',

            'Xem sân bóng',
            'Thêm sân bóng',
            'Sửa sân bóng',
            'Xoá sân bóng',

            'Xem loại sân bóng',
            'Thêm loại sân bóng',
            'Sửa loại sân bóng',
            'Xoá loại sân bóng',

            'Xem quy định',
            'Thêm quy định',
            'Sửa quy định',
            'Xoá quy định',

            'Xem khách hàng',
            'Thêm khách hàng',
            'Sửa khách hàng',
            'Xoá khách hàng',

            'Xem dịch vụ',
            'Thêm dịch vụ',
            'Sửa dịch vụ',
            'Xoá dịch vụ',

            'Xem loại dịch vụ',
            'Thêm loại dịch vụ',
            'Sửa loại dịch vụ',
            'Xoá loại dịch vụ',

            'Xem bảng điều khiển',

            'Xem đặt sân',
            'Thêm đặt sân',

            'Xem hoá đơn đặt sân',
            'Sửa hoá đơn đặt sân',
            'Xóa hoá đơn đặt sân',
            'Thanh toán hoá đơn đặt sân',
            'Thêm dịch vụ hoá đơn đặt sân',
            'Sửa dịch vụ hoá đơn đặt sân',

            'Xem hoá đơn bán lẻ',
            'Thêm hoá đơn bán lẻ',
            'Sửa hoá đơn bán lẻ',
            'Xóa hoá đơn bán lẻ',
            'Thanh toán hoá đơn bán lẻ',

            'Xem cài đặt',
         ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
