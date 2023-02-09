<?php

namespace App\Http\Services;

use Alert;
use App\Models\ServiceType;

class ServiceTypeService
{
    public function getAll()
    {
        $records = ServiceType::all();
        return $records;
    }

    public function store($request)
    {
        try {
            ServiceType::create($request->all());
            Alert::success('Thành công', 'Thêm loại dịch vụ thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Thêm loại dịch vụ thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function update($request, $serviceType)
    {
        try {
            $serviceType::update($request->all());
            Alert::success('Thành công', 'Cập nhật loại dịch vụ thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Cập nhật loại dịch vụ thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function destroy($serviceType)
    {
        try {
            $serviceType->delete();
            Alert::success('Thành công', 'Xoá loại dịch vụ thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Xoá loại dịch vụ thất bại! Vui lòng thử lại.');
            return false;
        }

        return true;
    }
}
