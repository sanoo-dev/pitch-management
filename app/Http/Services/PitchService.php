<?php

namespace App\Http\Services;

use Alert;
use App\Models\Pitch;
use App\Models\PitchType;
use Intervention\Image\Facades\Image;

class PitchService
{
    public function getAll()
    {
        $records = Pitch::orderBy('status')->get();
        return $records;
    }

    public function getPitchTypes()
    {
        $records = PitchType::orderBy('name')->get();
        return $records;
    }

    public function emptyPitchType()
    {
        if (PitchType::get()->count() > 0) {
            return false;
        }

        Alert::warning('Cảnh báo', 'Hiện tại chưa có loại sân nào! Vui lòng thêm loại sân trước.');
        return true;
    }

    public function store($request)
    {
        try {
            Pitch::create([
                'name' => $request->name,
                'image' => $this->handleUploadImage($request->file('image')),
                'location' => $request->location,
                'status' => $request->status,
                'pitch_type_id' => $request->pitch_type_id,
            ]);

            Alert::success('Thành công', 'Thêm sân thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Thêm sân thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function update($request, $pitch)
    {
        try {
            if ($request->file('image')) {
                $pitch->update([
                    'name' => $request->name,
                    'image' => $this->handleUploadImage($request->file('image')),
                    'location' => $request->location,
                    'status' => $request->status,
                    'pitch_type_id' => $request->pitch_type_id,
                ]);
                if ($request->old_image) {
                    unlink($request->old_image);
                }
            } else {
                $pitch->update([
                    'name' => $request->name,
                    'image' => $request->old_image,
                    'location' => $request->location,
                    'status' => $request->status,
                    'pitch_type_id' => $request->pitch_type_id,
                ]);
            }
            Alert::success('Thành công', 'Cập nhật sân bóng thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Cập nhật sân bóng thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function destroy($pitch)
    {
        try {
            if ($pitch->image) {
                unlink($pitch->image);
            }
            $pitch->delete();
            Alert::success('Thành công', 'Xoá sân bóng thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Xoá sân bóng thất bại! Vui lòng thử lại.');
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
