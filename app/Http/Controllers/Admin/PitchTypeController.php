<?php

namespace App\Http\Controllers\Admin;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PitchType;
use App\Http\Controllers\Controller;
use App\Http\Services\PitchTypeService;
use App\Http\Requests\StorePitchTypeRequest;
use App\Http\Requests\UpdatePitchTypeRequest;

class PitchTypeController extends Controller
{
    protected $pitchTypeService;

    public function __construct(PitchTypeService $pitchTypeService)
    {
        $this->pitchTypeService = $pitchTypeService;
        $this->middleware('permission:Xem loại sân bóng|Thêm loại sân bóng|Sửa loại sân bóng|Xoá loại sân bóng', ['only' => ['index','store']]);
        $this->middleware('permission:Thêm loại sân bóng', ['only' => ['create','store']]);
        $this->middleware('permission:Sửa loại sân bóng', ['only' => ['edit','update']]);
        $this->middleware('permission:Xoá loại sân bóng', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pitch-types.index', [
            'pitchTypes' => $this->pitchTypeService->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pitch-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePitchTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePitchTypeRequest $request)
    {
        $result = $this->pitchTypeService->store($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PitchType  $pitchType
     * @return \Illuminate\Http\Response
     */
    public function show(PitchType $pitchType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PitchType  $pitchType
     * @return \Illuminate\Http\Response
     */
    public function edit(PitchType $pitchType)
    {
        return view('admin.pitch-types.edit', [
            'pitchType' => $pitchType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePitchTypeRequest  $request
     * @param  \App\Models\PitchType  $pitchType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePitchTypeRequest $request, PitchType $pitchType)
    {
        $result = $this->pitchTypeService->update($request, $pitchType);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PitchType  $pitchType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PitchType $pitchType)
    {
        $result = $this->pitchTypeService->destroy($pitchType);
        return redirect()->back();
    }
}
