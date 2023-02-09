<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Services\OrderService;
use App\Models\Pitch;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('permission:Xem đặt sân|Thêm đặt sân|Xem hoá đơn đặt sân|Thanh toán hoá đơn đặt sân|Thêm dịch vụ hoá đơn đặt sân|Sửa dịch vụ hoá đơn đặt sân|Sửa hoá đơn đặt sân|Xóa hoá đơn đặt sân', ['only' => ['index','pitchBookingStatus', 'store']]);
        $this->middleware('permission:Thêm đặt sân', ['only' => ['create', 'store']]);
        $this->middleware('permission:Thanh toán hoá đơn đặt sân', ['only' => ['pay']]);
        $this->middleware('permission:Sửa hoá đơn đặt sân', ['only' => ['edit','update']]);
        $this->middleware('permission:Xóa hoá đơn đặt sân', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date ? $request->date : date('Y-m-d');

        return view('admin.orders.index', [
            'orders' => $this->orderService->getByDate($date),
            'date' => $date,
        ]);
    }

    public function pitchBookingStatus(Request $request) {
        $date = $request->date ? $request->date : date('Y-m-d');
        return view('admin.pitch-booking-status.index', [
            'date' => $date,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($date)
    {
        $setting = Setting::first();
        return view('admin.orders.create', [
            'pitches' => Pitch::where('status', 1)->get(),
            'date' => $date,
            'hour_open' => date('H', strtotime($setting->open_time)),
            'minute_open' => date('i', strtotime($setting->open_time)),
            'hour_close' => date('H', strtotime($setting->close_time)),
            'minute_close' => date('i', strtotime($setting->close_time)),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $result = $this->orderService->store($request);
        if ($result) {
            return redirect()->route('admin.orders.index', [
                'date' => $request->booking_date,
            ]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order, $date)
    {
        return view('admin.orders.edit', [
            'pitches' => Pitch::all(),
            'order' => $order,
            'date' => $date,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $result = $this->orderService->update($request, $order);
        return redirect()->route('admin.orders.index', [
            'date' => $request->booking_date,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $result = $this->orderService->destroy($order);
        return redirect()->back();
    }

    public function pay(Order $order)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $result = $this->orderService->pay($order);
        return view('admin.orders.print-order', [
            'order' => $order,
            'date' => date('Y-m-d H:i:s')
        ]);

        // $abc = 'áđđ';
        // $date = date('Y-m-d H:i:s');
        // return view('admin.orders.print-order', compact('order', 'abc', 'date'));
    }

    public function take(Order $order)
    {
        $order->pay_status = 0;
        $order->save();
        return back();
    }

    public function getByDate($date)
    {
        return OrderResource::collection($this->orderService->getByDate($date));
    }
}
