<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pitch;
use App\Http\Requests\StorePitchRequest;
use App\Http\Requests\UpdatePitchRequest;
use App\Http\Services\PitchService;

class PitchController extends Controller
{
    protected $pitchService;

    public function __construct(PitchService $pitchService)
    {
        $this->pitchService = $pitchService;
        $this->middleware('permission:Xem sân bóng|Thêm sân bóng|Sửa sân bóng|Xoá sân bóng', ['only' => ['index','store']]);
        $this->middleware('permission:Thêm sân bóng', ['only' => ['create','store']]);
        $this->middleware('permission:Sửa sân bóng', ['only' => ['edit','update']]);
        $this->middleware('permission:Xoá sân bóng', ['only' => ['destroy']]);
    }

    public function getAll() {
        $records = Pitch::where('status', 1)->get();
        return response()->json($records);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pitches.index', [
            'pitches' => $this->pitchService->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->pitchService->emptyPitchType()) {
            return redirect()->back();
        }
        return view('admin.pitches.create', [
            'pitchTypes' => $this->pitchService->getPitchTypes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePitchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePitchRequest $request)
    {
        $result = $this->pitchService->store($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pitch  $pitch
     * @return \Illuminate\Http\Response
     */
    public function show(Pitch $pitch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pitch  $pitch
     * @return \Illuminate\Http\Response
     */
    public function edit(Pitch $pitch)
    {
        return view('admin.pitches.edit', [
            'pitchTypes' => $this->pitchService->getPitchTypes(),
            'pitch' => $pitch,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePitchRequest  $request
     * @param  \App\Models\Pitch  $pitch
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePitchRequest $request, Pitch $pitch)
    {
        $result = $this->pitchService->update($request, $pitch);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pitch  $pitch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pitch $pitch)
    {
        $result = $this->pitchService->destroy($pitch);
        return redirect()->back();
    }
}
