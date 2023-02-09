<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderServiceRequest;
use App\Http\Requests\UpdateOrderServiceRequest;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class OrderServiceController extends Controller
{
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('permission:Thêm dịch vụ hoá đơn đặt sân|Sửa dịch vụ hoá đơn đặt sân', ['only' => ['index', 'store']]);
        $this->middleware('permission:Thêm dịch vụ hoá đơn đặt sân', ['only' => ['create', 'store']]);
        $this->middleware('permission:Sửa dịch vụ hoá đơn đặt sân', ['only' => ['edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order)
    {
        $date = $request->date ? $request->date : date('Y-m-d');
        return view('admin.order-services.index', [
            'order' => $order,
            'date' => $date,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Order $order)
    {
        $date = $request->date ? $request->date : date('Y-m-d');
        return view('admin.order-services.create',[
            'order' => $order,
            'date' => $date,
            'serviceTypes' => ServiceType::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderServiceRequest $request, Order $order)
    {
        $serviceInOrderService = $order->orderServices()->where('service_id', $request->service_id)->first();
        $service = Service::find($request->service_id);

        if ($serviceInOrderService) {
            $serviceInOrderService->quantity = $serviceInOrderService->quantity + $request->quantity;
            $serviceInOrderService->save();

            // Update inventory for service
            $newInventory = $service->inventory - $request->quantity;
            $service->inventory = $newInventory;
            $service->save();
        } else {
            $order->orderServices()->create([
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
     * @param  \App\Models\OrderService  $orderService
     * @return \Illuminate\Http\Response
     */
    public function show(OrderService $orderService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderService  $orderService
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $order, OrderService $orderService)
    {
        $date = $request->date ? $request->date : date('Y-m-d');
        return view('admin.order-services.edit', [
            'order' => $order,
            'date' => $date,
            'orderService' => $orderService,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderService  $orderService
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderServiceRequest $request, OrderService $orderService, $date)
    {
        $service = $orderService->service;
        $oldQuantity = $orderService->quantity;
        $newQuantity = $request->quantity;

        if ($oldQuantity > $newQuantity) {
            $temp = $oldQuantity - $newQuantity;
            $service->inventory = $service->inventory + $temp;
        } else {
            $temp = $newQuantity - $oldQuantity;
            $service->inventory = $service->inventory - $temp;
        }

        $service->save();

        $orderService->quantity = $request->quantity;
        $orderService->save();

        Alert::success('Thành công', 'Cập nhật thành công.');

        $goBack = route('admin.order-services.index', $orderService->order) . '?date=' . $date;
        return redirect($goBack);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderService  $orderService
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderService $orderService)
    {
        $service = $orderService->service;
        $service->inventory = $service->inventory + $orderService->quantity;
        $service->save();

        $orderService->delete();

        Alert::success('Thành công', 'Xoá thành công.');

        return redirect()->back();
    }
}
