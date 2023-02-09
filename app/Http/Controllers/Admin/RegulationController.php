<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulation;
use App\Http\Requests\StoreRegulationRequest;
use App\Http\Requests\UpdateRegulationRequest;
use App\Http\Services\RegulationService;

class RegulationController extends Controller
{
    protected $regulationService;

    public function __construct(RegulationService $regulationService)
    {
        $this->regulationService = $regulationService;
        $this->middleware('permission:Xem quy định|Thêm quy định|Sửa quy định|Xoá quy định', ['only' => ['index','store']]);
        $this->middleware('permission:Thêm quy định', ['only' => ['create','store']]);
        $this->middleware('permission:Sửa quy định', ['only' => ['edit','update']]);
        $this->middleware('permission:Xoá quy định', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.regulations.index', [
            'regulations' => $this->regulationService->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.regulations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegulationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegulationRequest $request)
    {
        $result = $this->regulationService->store($request);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regulation  $regulation
     * @return \Illuminate\Http\Response
     */
    public function show(Regulation $regulation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Regulation  $regulation
     * @return \Illuminate\Http\Response
     */
    public function edit(Regulation $regulation)
    {
        return view('admin.regulations.edit', [
            'regulation' => $regulation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegulationRequest  $request
     * @param  \App\Models\Regulation  $regulation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegulationRequest $request, Regulation $regulation)
    {
        $result = $this->regulationService->update($request, $regulation);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Regulation  $regulation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regulation $regulation)
    {
        $result = $this->regulationService->destroy($regulation);
        return redirect()->back();
    }
}
