<?php

namespace App\Http\Controllers;

use App\Models\Service;
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
        $bounds = [
            'north' => $request->input('n'),
            'south' => $request->input('s'),
            'east'  => $request->input('e'),
            'west'  => $request->input('w'),
        ];

        // Lire et normaliser les services
        $serviceIds = (array) $request->input('services');
        if (is_string($serviceIds)) {
            $serviceIds = explode(',', $serviceIds);
        } elseif (!is_array($serviceIds)) {
            $serviceIds = [];
        }

        // Lire l’opérateur (par défaut OR)
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

}
