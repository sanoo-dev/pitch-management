<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Services\ServiceService;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
        $this->middleware('permission:Xem dịch vụ|Thêm dịch vụ|Sửa dịch vụ|Xoá dịch vụ', ['only' => ['index','store']]);
        $this->middleware('permission:Thêm dịch vụ', ['only' => ['create','store']]);
        $this->middleware('permission:Sửa dịch vụ', ['only' => ['edit','update']]);
        $this->middleware('permission:Xoá dịch vụ', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.services.index', [
            'services' => $this->serviceService->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->serviceService->emptyServiceType()) {
            return redirect()->back();
        }

        return view('admin.services.create', [
            'serviceTypes' => $this->serviceService->getServiceTypes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $result = $this->serviceService->store($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', [
            'serviceTypes' => $this->serviceService->getServiceTypes(),
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $result = $this->serviceService->update($request, $service);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $result = $this->serviceService->destroy($service);
        return redirect()->back();
    }
}
