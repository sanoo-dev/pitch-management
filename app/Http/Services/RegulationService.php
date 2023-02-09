<?php

namespace App\Http\Services;

use Alert;
use App\Models\Regulation;

class RegulationService
{
    public function getAll()
    {
        $records = Regulation::all();
        return $records;
    }

    public function store($request)
    {
        try {
            Regulation::create($request->all());
            Alert::success('Thành công', 'Thêm quy định thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Thêm quy định thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function update($request, $regulation)
    {
        try {
            $regulation->update($request->all());
            Alert::success('Thành công', 'Cập nhật quy định thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Cập nhật quy định thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function destroy($regulation)
    {
        try {
            $regulation->delete();
            Alert::success('Thành công', 'Xoá quy định thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Xoá quy định thất bại! Vui lòng thử lại.');
            return false;
        }

        return true;
    }
}
