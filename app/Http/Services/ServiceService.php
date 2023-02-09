<?php

namespace App\Http\Services;

use Alert;
use App\Models\Service;
use App\Models\ServiceType;
use Intervention\Image\Facades\Image;

class ServiceService
{
    public function getAll()
    {
        $records = Service::all();
        return $records;
    }

    public function getServiceTypes()
    {
        $records = ServiceType::orderBy('name')->get();
        return $records;
    }

    public function emptyServiceType()
    {
        if (ServiceType::get()->count() > 0) {
            return false;
        }

        Alert::warning('Cảnh báo', 'Hiện tại chưa có loại dịch vụ nào! Vui lòng thêm loại dịch vụ trước.');
        return true;
    }

    public function store($request)
    {
        try {
            Service::create([
                'name' => $request->name,
                'image' => $this->handleUploadImage($request->file('image')),
                'price' => $request->price,
                'service_type_id' => $request->service_type_id,
                'status' => $request->status,
                'inventory' => $request->inventory,
            ]);
            Alert::success('Thành công', 'Thêm dịch vụ thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Thêm dịch vụ thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function update($request, $service)
    {
        try {
            if ($request->file('image')) {
                $service->update([
                    'name' => $request->name,
                    'image' => $this->handleUploadImage($request->file('image')),
                    'price' => $request->price,
                    'service_type_id' => $request->service_type_id,
                    'status' => $request->status,
                    'inventory' => $request->inventory,

                ]);
                if ($request->old_image) {
                    unlink($request->old_image);
                }
            } else {
                $service->update([
                    'name' => $request->name,
                    'image' => $request->old_image,
                    'price' => $request->price,
                    'service_type_id' => $request->service_type_id,
                    'status' => $request->status,
                    'inventory' => $request->inventory,
                ]);
            }
            Alert::success('Thành công', 'Cập nhật dịch vụ thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Cập nhật dịch vụ thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function destroy($service)
    {
        try {
            if ($service->image) {
                unlink($service->image);
            }
            $service->delete();
            Alert::success('Thành công', 'Xoá dịch vụ thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Xoá dịch vụ thất bại! Vui lòng thử lại.');
            return false;
        }

        return true;
    }

    public function handleUploadImage($file)
    {
        $image = '';
        if ($file) {
            $fileName = time() . '-' . $file->getClientOriginalName();
            Image::make($file)->resize(400, 300)->save('backend/images/' . $fileName);
            $image = 'backend/images/' . $fileName;
        }
        return $image;
    }
}
