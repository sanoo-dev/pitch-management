<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Alert;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem cài đặt', ['only' => ['index', 'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        return view('admin.settings.index', [
            'setting' => $setting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update($request->all());

        Alert::success('Thành công', 'Lưu thành công.');
        return redirect()->route('admin.index');
    }

}
