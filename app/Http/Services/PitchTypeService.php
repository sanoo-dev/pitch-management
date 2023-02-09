<?php

namespace App\Http\Services;

use Alert;

use App\Models\PitchType;
use App\Models\Regulation;
use Intervention\Image\Facades\Image;


class PitchTypeService
{
    public function getAll()
    {
        $records = PitchType::all();
        return $records;
    }

    public function store($request)
    {
        try {
            PitchType::create([
                    'name' => $request->name,
                    'image' => $this->handleUploadImage($request->file('image')),
                    'price' => $request->price,
                    'introduce' => $request->introduce,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
            ]);
            Alert::success('Thành công', 'Thêm loại sân thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Thêm loại sân thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function update($request, $pitchType)
    {
        try {
            if ($request->file('image')) {
                $pitchType->update([
                    'name' => $request->name,
                    'image' => $this->handleUploadImage($request->file('image')),
                    'price' => $request->price,
                    'introduce' => $request->introduce,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
                ]);
                if ($request->old_image) {
                    unlink($request->old_image);
                }
            } else {
                $pitchType->update([
                    'name' => $request->name,
                    'image' => $this->handleUploadImage($request->file('image')),
                    'price' => $request->price,
                    'introduce' => $request->introduce,
                    'capacity' => $request->capacity,
                    'description' => $request->description,
                ]);
            }
            Alert::success('Thành công', 'Cập nhật loại sân thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Cập nhật loại sân thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }

    public function destroy($pitchType)
    {
        try {
            if ($pitchType->image) {
                unlink($pitchType->image);
            }
            $pitchType->delete();
            Alert::success('Thành công', 'Xoá loại sân thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Xoá loại sân thất bại! Vui lòng thử lại.');
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
