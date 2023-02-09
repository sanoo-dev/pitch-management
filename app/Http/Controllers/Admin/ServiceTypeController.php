<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use App\Http\Requests\StoreServiceTypeRequest;
use App\Http\Requests\UpdateServiceTypeRequest;
use App\Http\Services\ServiceTypeService;

class ServiceTypeController extends Controller
{
    protected $serviceTypeService;

    public function __construct(ServiceTypeService $serviceTypeService)
    {
        $this->serviceTypeService = $serviceTypeService;
        $this->middleware('permission:Xem loại dịch vụ|Thêm loại dịch vụ|Sửa loại dịch vụ|Xoá loại dịch vụ', ['only' => ['index','store']]);
        $this->middleware('permission:Thêm loại dịch vụ', ['only' => ['create','store']]);
        $this->middleware('permission:Sửa loại dịch vụ', ['only' => ['edit','update']]);
        $this->middleware('permission:Xoá loại dịch vụ', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.service-types.index', [
            'serviceTypes' => $this->serviceTypeService->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceTypeRequest $request)
    {
        $result = $this->serviceTypeService->store($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceType $serviceType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceType $serviceType)
    {
        return view('admin.service-types.edit', [
            'serviceType' => $serviceType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceTypeRequest  $request
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceTypeRequest $request, ServiceType $serviceType)
    {
        $result = $this->serviceTypeService->update($request, $serviceType);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceType $serviceType)
    {
        $result = $this->serviceTypeService->destroy($serviceType);
        return redirect()->back();
    }
}
