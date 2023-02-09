<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Pitch;
use App\Models\PitchType;
use App\Models\Retail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem bảng điều khiển', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $this->data['date1'] = $request->date1 ?? null;
        $this->data['date2'] = $request->date2 ?? null;
        $this->data['option'] = null;

        $this->data['rankCustomers'] = Customer::orderBy('times_booked', 'DESC')->take(3)->get();
        $this->data['rankPitchTypes'] = $this->rankPitchTypes();

        if ($request->option == 'current_week') {
            $this->data['option'] = 'current_week';
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            $this->data['sales'] = Order::whereBetween('time_start', [$startOfWeek, $endOfWeek])
            ->orderBy('time_start')
            ->where('pay_status', 1)
            // ->orWhere('pay_status', 0)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->time_start));
            });

            $this->data['saleRetails'] = Retail::whereBetween('updated_at', [$startOfWeek, $endOfWeek])
            ->orderBy('updated_at')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->updated_at));
            });
        }
        else if ($request->option == 'current_month') {
            $this->data['option'] = 'current_month';
            $current_month = Carbon::now()->month;

            $this->data['sales'] = Order::whereMonth('time_start', $current_month)
            ->orderBy('time_start')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->time_start));
            });

            $this->data['saleRetails'] = Retail::whereMonth('updated_at', $current_month)
            ->orderBy('updated_at')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->updated_at));
            });
        }
        else if ($request->option == 'current_year') {
            $this->data['option'] = 'current_year';
            $current_year = Carbon::now()->year;
            $this->data['sales'] = Order::whereYear('time_start', $current_year)
            ->orderBy('time_start')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->time_start));
            });

            $this->data['saleRetails'] = Retail::whereYear('updated_at', $current_year)
            ->orderBy('updated_at')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->updated_at));
            });
        }
        else if ($this->data['date1'] && $this->data['date2']) {
            $this->data['sales'] = Order::whereBetween('time_start', [$this->data['date1'], $this->data['date2']])
            ->where('pay_status', 1)
            ->orderBy('time_start')
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->time_start));
            });

            $this->data['saleRetails'] = Retail::whereBetween('updated_at', [$this->data['date1'], $this->data['date2']])
            ->orderBy('updated_at')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->updated_at));
            });
        }
        else {
            $this->data['sales'] = Order::orderBy('time_start')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->time_start));
            });

            $this->data['saleRetails'] = Retail::orderBy('updated_at')
            ->where('pay_status', 1)
            ->get()
            ->groupBy(function($date) {
                return date('Y-m-d', strtotime($date->updated_at));
            });
        }

        return view('admin.sales.index', $this->data);
    }

    public function rankPitchTypes()
    {
        $pitchTypes = PitchType::all();
        $rankPitchTypes = [];
        foreach ($pitchTypes as $pitchType) {
            $object = new stdClass();
            $object->pitchType = $pitchType;
            $object->count_order = 0;
            foreach ($pitchType->pitches as $pitch) {
                $object->count_order = $object->count_order + count($pitch->orders);
            }

            $rankPitchTypes[] = $object;
        }

        // sort rank
        function cmp($a, $b) {
            return strcmp($a->count_order, $b->count_order);
        }

        usort($rankPitchTypes, function ($a, $b) {
            return $a->count_order < $b->count_order;
        });

        return array_slice($rankPitchTypes, 0, 3);
    }
}
