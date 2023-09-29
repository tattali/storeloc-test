<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class StorelocController extends Controller
{
    public function index()
    {
        return view('index', [
            'services' => Service::all(),
        ]);
    }
}
