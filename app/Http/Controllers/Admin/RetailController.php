<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Retail;
use Illuminate\Http\Request;
use Alert;

class RetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem hoá đơn bán lẻ|Thêm hoá đơn bán lẻ|Sửa hoá đơn bán lẻ|Xoá hoá đơn bán lẻ', ['only' => ['index']]);
        $this->middleware('permission:Thêm hoá đơn bán lẻ', ['only' => ['create']]);
        $this->middleware('permission:Thanh toán hoá đơn bán lẻ', ['only' => ['pay']]);
        $this->middleware('permission:Xóa hoá đơn bán lẻ', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date ? $request->date : date('Y-m-d');
        $retails = Retail::whereDate('created_at', $date)->get();
        return view('admin.retails.index', [
            'retails' => $retails,
            'date' => $date,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $retail = new Retail();
        $retail->employee_id = auth()->user()->id;
        $retail->save();
        return redirect()->route('admin.retail-details.create', $retail);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function show(Retail $retail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function edit(Retail $retail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retail $retail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retail $retail)
    {
        foreach ($retail->retailDetails as $retailDetail) {
            $service = $retailDetail->service;
            $service->inventory = $service->inventory + $retailDetail->quantity;
            $service->save();
        }

        $retail->delete();

        Alert::success('Thành công', 'Xoá thành công.');
        return back();
    }

    public function pay(Retail $retail)
    {
        if ($retail->retailDetails->count() < 1) {
            Alert::error('Thất bại', 'Không có gì để thanh toán ở đây cả.');
            return back();
        }

        $retail->pay_status = 1;
        $retail->save();
        
        Alert::success('Thành công', 'Thanh toán thành công.');
        return view('admin.retail-details.print-order', [
            'retail' => $retail,
        ]);
    }
}
