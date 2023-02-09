<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Pitch;
use App\Models\Retail;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem bảng điều khiển', ['only' => ['index']]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index', [
            'countCustomer' => count(Customer::all()),
            'countPitch' => count(Pitch::all()),
            'countService' => count(Service::all()),
            'totalTurnover' => $this->totalTurnover(),
        ]);
    }

    public function totalTurnover()
    {
        $orders = Order::where('pay_status', 1)->get();
        $totalTurnover = 0;

        foreach ($orders as $order) {

            $pitchFee = $this->calculatePitchFee($order);
            $serviceFee = 0;
            foreach ($order->orderServices as $orderService) {
                $serviceFee += $orderService->quantity * $orderService->price;
            }

            $totalTurnover += $pitchFee + $serviceFee;
        }

        $retails = Retail::where('pay_status', 1)->get();
        foreach ($retails as $retail) {
            $retailFee = 0;
            foreach ($retail->retailDetails as $retailDetail) {
                $retailFee += $retailDetail->quantity * $retailDetail->price;
            }

            $totalTurnover += $retailFee;
        }

        return $totalTurnover;
    }

    // trả về giá cuối cùng
    public function calculatePitchFee($order)
    {
        $orderHourStart = date('H', strtotime($order->time_start));
        $orderHourEnd = date('H', strtotime($order->time_end));
        $pitchFee = 0;

        if ($orderHourStart >= 5 && $orderHourStart < 9) {
            if ($orderHourEnd > 9) {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price, '09:00:00');
            } else {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else if ($orderHourStart >= 9 && $orderHourStart < 15) {
            if ($orderHourEnd > 15) {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price, '15:00:00');
            } else {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else if ($orderHourStart >= 15 && $orderHourStart < 18) {
            if ($orderHourEnd > 18) {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price, '18:00:00');
            } else {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else if ($orderHourStart >= 18 && $orderHourStart < 23) {
            if ($orderHourEnd > 23) {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price, '23:00:00');
            } else {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        } else {
            if ($orderHourEnd > 5) {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price, '05:00:00');
            } else {
                $pitchFee = $this->getPitchFee($order->time_start, $order->time_end, $order->price);
            }
        }

        return $pitchFee;
    }

    // trả về giá 1 sân
    public function getPitchFee($timeStart, $timeEnd, $price, $breakTime = null) {
        $orderDate = date('Y-m-d', strtotime($timeStart));
        $pFee = 0;
        if ($breakTime) {
            $hourStart = date('H', strtotime($timeStart));
            $hourEnd = date('H', strtotime($timeEnd));

            $breakDateTime = date('Y-m-d H:i:s', strtotime($orderDate . ' ' . $breakTime));
            $pFee += $this->getTotalMinutes($timeStart, $breakDateTime) * $this->getPrice($timeStart, $price);
            $pFee += $this->getTotalMinutes($breakDateTime, $timeEnd) * $this->getPrice($timeEnd, $price);
        } else {
            $pFee += $this->getTotalMinutes($timeStart, $timeEnd) * $this->getPrice($timeStart, $price);
        }
        return $pFee;
    }

    public function getPrice($dateTime, $price) {
        $hour = date('H', strtotime($dateTime));
        $weekend =  date('D', strtotime($dateTime));

        if ($weekend === 'Sat' || $weekend === 'Sun') {
            if ($hour >= 5 && $hour < 9) {
                return $price *= 1;
            }
            if($hour >= 9 && $hour < 15){
                return $price *= 0.8;
            }
            if($hour >= 15 && $hour < 18){
                return $price *= 1.6;
            }
            if($hour >= 18 && $hour < 23){
                return $price *= 2.2;
            }
            else {
                return $price *= 1.6;
            }
        } else {
            if ($hour >= 5 && $hour < 9) {
                return $price *= 1;
            }
            if($hour >= 9 && $hour < 15){
                return $price *= 0.8;
            }
            if($hour >= 15 && $hour < 18){
                return $price *= 1.4;
            }
            if($hour >= 18 && $hour < 23){
                return $price *= 2;
            }
            else {
                return $price *= 1.6;
            }
        }

    }

    public function getTotalMinutes($timeStart, $timeEnd) {
        $ts = strtotime($timeStart);
        $te = strtotime($timeEnd);
        return date('H', $te-$ts) * 60 + date('i', $te-$ts);
    }
}
