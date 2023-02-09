<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Pitch;
use App\Models\PitchType;
use App\Models\Regulation;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class HomeController extends Controller
{
    public function getPitches() {
        $records = Pitch::where('status', 1)->get();
        return response()->json($records);
    }


    // lấy danh sách hóa đơn
    public function getOrders($date) {
        $date ?? date('Y-m-d');
        $records = Order::where('time_start', 'LIKE', $date . '%')->orderBy('created_at')->get();
        return OrderResource::collection($records);
    }

    public function index(Request $request)
    {
        $pitchTypes = PitchType::all();
        $serviceTypes = ServiceType::all();
        $setting = Setting::first();
        $regulation = Regulation::first();
        $customers = Customer::all();
        $pitches = Pitch::all();
        $services = Service::all();
        $date = $request->date ? $request->date : date('Y-m-d');
        return view('pages.index', [
            'date' => $date,
            'pitchTypes' => $pitchTypes,
            'serviceTypes' => $serviceTypes,
            'setting' => $setting,
            'regulation' => $regulation,
            'customers' => $customers,
            'pitches' => $pitches,
            'services' => $services,
        ]);
    }
}
