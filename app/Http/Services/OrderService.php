<?php

namespace App\Http\Services;

use Alert;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Pitch;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getByDate($date)
    {
        $records = Order::where('time_start', 'LIKE', $date . '%')->orderBy('created_at')->get();
        return $records;
    }

    public function getServices()
    {
        $records = Service::orderBy('name')->get();
        return $records;
    }

    public function store($request)
    {
        $pitch = Pitch::find($request->pitch_id);

        $ts = strtotime("$request->hour_start:$request->minute_start $request->booking_date");
        $time_start = date('Y-m-d H:i:s' , $ts);

        $te = strtotime("$request->hour_end:$request->minute_end $request->booking_date");
        $time_end = date('Y-m-d H:i:s' , $te);

        $countDuplicateOrder = Order::where('pitch_id', $request->pitch_id)
            ->where(function ($query) use ($time_start, $time_end){
                $query->where(function ($query) use ($time_start, $time_end){
                    $query->where('time_start', '>=', $time_start);
                    $query->where('time_start', '<=', $time_end);
                })
                ->orWhere(function ($query) use ($time_start, $time_end){
                    $query->where('time_start', '<=', $time_start)
                    ->where('time_end', '>=', $time_start);
                });
            })->count();
            // dd($countDuplicateOrder);

        if ($countDuplicateOrder != 0) {
            Alert::error('Thất bại', 'Sân đặt bị trùng thời gian.');
            return false;
        } else {
            try {
                if ($request->customer_id) {
                    $now = date('Y-m-d', strtotime($time_start));
                    $countOrders = Order::whereDate('time_start', $now)
                                ->where('pay_status', '<>', 1)
                                ->where('customer_id', $request->customer_id)
                                ->count();
                    if ($countOrders === 0) {
                        Order::create([
                            'pitch_id' => $request->pitch_id,
                            'employee_id' => $request->employee_id,
                            'customer_id' => $request->customer_id,
                            'time_start' => $time_start,
                            'time_end' => $time_end,
                            'price' => $pitch->pitchType->price,
                            'pay_status' => 2,
                        ]);

                    } else {
                        Alert::error('Thất bại', 'Khách hàng này đã đặt sân rồi.');
                        return false;
                    }
                } else {
                    $customer = Customer::create([
                        'name' => $request->customer_name,
                        'phone_number' => $request->customer_phone_number,
                        'times_booked' => 0,
                    ]);

                    Order::create([
                        'pitch_id' => $request->pitch_id,
                        'employee_id' => $request->employee_id,
                        'customer_id' => $customer->id,
                        'time_start' => $time_start,
                        'time_end' => $time_end,
                        'price' => $pitch->pitchType->price,
                        'pay_status' => 2,
                    ]);
                }

                Alert::success('Thành công', 'Đặt sân thành công.');
            } catch (\Exception $e) {
                Alert::error('Thất bại', 'Đặt sân thất bại! Vui lòng thử lại.');
                return false;
            }
        }

        return true;
    }

    public function update($request, $order)
    {
        $pitch = Pitch::find($request->pitch_id);

        $ts = strtotime("$request->hour_start:$request->minute_start $request->booking_date");
        $time_start = date('Y-m-d H:i:s' , $ts);

        $te = strtotime("$request->hour_end:$request->minute_end $request->booking_date");
        $time_end = date('Y-m-d H:i:s' , $te);

        $countDuplicateOrder = Order::where('pitch_id', $request->pitch_id)
            ->where(function ($query) use ($time_start, $time_end){
                $query->where(function ($query) use ($time_start, $time_end){
                    $query->where('time_start', '>=', $time_start);
                    $query->where('time_start', '<=', $time_end);
                })
                ->orWhere(function ($query) use ($time_start, $time_end){
                    $query->where('time_start', '<=', $time_start)
                    ->where('time_end', '>=', $time_start);
                });
            })->count();
            // dd($countDuplicateOrder);

        if ($countDuplicateOrder != 0) {
            Alert::error('Thất bại', 'Sân đặt bị trùng thời gian.');
            return false;
        } else {
            try {

                if ($request->customer_id) {
                    $order->price = $request->price;
                    $order->pitch_id = $request->pitch_id;
                    $order->time_end = $request->time_end;
                    $order->save();
                }

                Alert::success('Thành công', 'Cập nhật đặt sân thành công.');
            } catch (\Exception $e) {
                Alert::error('Thất bại', 'Cập nhật đặt sân thất bại! Vui lòng thử lại.');
                return false;
            }
        }
        return true;
    }

    public function destroy($order)
    {
        try {
            foreach ($order->orderServices as $orderService) {
                $service = $orderService->service;
                $service->inventory = $service->inventory + $orderService->quantity;
                $service->save();
            }
            $order->delete();
            Alert::success('Thành công', 'Xoá hoá đơn thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Xoá hoá đơn thất bại! Vui lòng thử lại.');
            return false;
        }

        return true;
    }

    public function pay($order)
    {

        try {
            $order->pay_status = 1;
            $order->save();

            $order->customer->times_booked = $order->customer->times_booked + 1;
            $order->customer->save();

            Alert::success('Thành công', 'Thanh toán thành công.');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Thanh toán thất bại! Vui lòng thử lại.');
            return false;
        }
        return true;
    }
}
