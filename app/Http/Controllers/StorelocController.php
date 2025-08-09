<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Store;
use Illuminate\Http\Request;

class StorelocController extends Controller
{
    public function index()
    {
        return view('store.index', [
            'services' => Service::all(),
        ]);
    }

    public function results(Request $request)
    {
        $serviceIds = (array) $request->input('services');
        if (is_string($serviceIds)) {
            $serviceIds = explode(',', $serviceIds);
        } elseif (!is_array($serviceIds)) {
            $serviceIds = [];
        }

        $request->validate([
            'n' => 'required|numeric',
            's' => 'required|numeric',
            'e' => 'required|numeric',
            'w' => 'required|numeric',
            'services.*' => 'required|exists:services,id',
            'operator' => 'required|in:AND,OR',
        ]);

        $bounds = [
            'north' => $request->input('n'),
            'south' => $request->input('s'),
            'east'  => $request->input('e'),
            'west'  => $request->input('w'),
        ];

        $operator = strtoupper($request->input('operator', 'OR'));
        if (!in_array($operator, ['AND', 'OR'])) {
            $operator = 'OR';
        }

        $cacheKey = 'stores_' . md5(json_encode($bounds) . json_encode($serviceIds) . $operator);
        $stores = cache()->remember($cacheKey, 1440, function () use ($bounds, $serviceIds, $operator) {
            return Store::filterByBoundsAndServices($bounds, $serviceIds, $operator)->get();
        });

        return view('store.results', [
            'stores' => $stores,
        ]);
    }

    public function show($id)
    {
        $store = Store::findOrFail($id);

        $isOpen = false;
        $currentDay = now()->format('l');
        $currentTime = now()->format('H:i');
        if (isset($store->hours[$currentDay])) {
            foreach ($store->hours[$currentDay] as $timeRange) {
                [$start, $end] = explode('-', $timeRange);
                if ($currentTime >= $start && $currentTime <= $end) {
                    $isOpen = true;
                    break;
                }
            }
        }


        return view('store.show', [
            'store' => $store,
            'services' => $store->services,
            'isOpen' => $isOpen,
        ]);
    }
}
