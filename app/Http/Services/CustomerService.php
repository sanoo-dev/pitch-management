<?php

namespace App\Http\Services;

use Alert;
use App\Models\Customer;

class CustomerService
{
    public function getAll()
    {
        $records = Customer::all();
        return $records;
    }

    public function getByPhone($phoneNumber)
    {
        $records = Customer::where('phone_number', $phoneNumber)->get();
        return $records;
    }

    public function store($request)
    {
        try {
            Customer::create($request->all());
            Alert::success('Thành công', 'Thêm loại khách hàng công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Thêm khách hàng thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function update($request, $customer)
    {
        try {
            $customer->update($request->all());
            Alert::success('Thành công', 'Cập nhật khách hàng thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Cập nhật khách hàng thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function destroy($customer)
    {
        try {
            $customer->delete();
            Alert::success('Thành công', 'Xoá khách hàng thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Xoá khách hàng thất bại! Vui lòng thử lại.');
            return false;
        }

        return true;
    }
}
