<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Retail;
use App\Models\RetailDetail;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Alert;
use App\Models\Service;

class RetailDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem hoá đơn bán lẻ|Thêm hoá đơn bán lẻ|Sửa hoá đơn bán lẻ|Xoá hoá đơn bán lẻ', ['only' => ['index', 'store']]);
        $this->middleware('permission:Thêm hoá đơn bán lẻ', ['only' => ['create', 'store']]);
        $this->middleware('permission:Sửa hoá đơn bán lẻ', ['only' => ['edit','update']]);
        $this->middleware('permission:Xóa hoá đơn bán lẻ', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Retail $retail)
    {
        return view('admin.retail-details.index', [
            'retail' => $retail,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Retail $retail)
    {
        $serviceTypes = ServiceType::with('services')->get();
        return view('admin.retail-details.create', [
            'retail' => $retail,
            'serviceTypes' => $serviceTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Retail $retail)
    {
        $service = Service::find($request->service_id);
        $serviceInRetailDetail = $retail->retailDetails()->where('service_id', $request->service_id)->first();
        if ($serviceInRetailDetail) {
            $serviceInRetailDetail->quantity = $serviceInRetailDetail->quantity + $request->quantity;
            $serviceInRetailDetail->save();

            // Update inventory for service
            $newInventory = $service->inventory - $request->quantity;
            $service->inventory = $newInventory;
            $service->save();
        } else {
            $retail->retailDetails()->create([
                'service_id' => $request->service_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);

            // Update inventory for service
            $newInventory = $service->inventory - $request->quantity;
            $service->inventory = $newInventory;
            $service->save();
        }

        Alert::success('Thành công', 'Mua thành công.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RetailDetail  $retailDetail
     * @return \Illuminate\Http\Response
     */
    public function show(RetailDetail $retailDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RetailDetail  $retailDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(Retail $retail, RetailDetail $retailDetail)
    {
        return view('admin.retail-details.edit', [
            'retail' => $retail,
            'retailDetail' => $retailDetail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RetailDetail  $retailDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RetailDetail $retailDetail)
    {
        $service = $retailDetail->service;
        $oldQuantity = $retailDetail->quantity;
        $newQuantity = $request->quantity;

        if ($oldQuantity > $newQuantity) {
            $temp = $oldQuantity - $newQuantity;
            $service->inventory = $service->inventory + $temp;
        } else {
            $temp = $newQuantity - $oldQuantity;
            $service->inventory = $service->inventory - $temp;
        }

        $service->save();

        $retailDetail->quantity = $request->quantity;
        $retailDetail->save();

        Alert::success('Thành công', 'Cập nhật thành công.');

        return redirect()->route('admin.retail-details.index', $retailDetail->retail);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RetailDetail  $retailDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetailDetail $retailDetail)
    {
        $service = $retailDetail->service;
        $service->inventory = $service->inventory + $retailDetail->quantity;
        $service->save();
        
        $retailDetail->delete();

        Alert::success('Thành công', 'Xoá thành công.');

        return redirect()->back();
    }

}
