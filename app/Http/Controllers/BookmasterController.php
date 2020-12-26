<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmaster;

class BookmasterController extends Controller
{
    public function index()
    {
        $bookmasters = Bookmaster::all()->toArray();
        return response()->json([
            'success' => true,
            'data' => $bookmasters
        ]);
    }
}
