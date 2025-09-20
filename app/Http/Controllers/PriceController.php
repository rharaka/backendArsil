<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use Illuminate\Http\Request;
use DB;

class PriceController extends Controller
{
    public function getPrices(Request $request) {
        $prices = DB::table('prices')->where('WEIGHT_FROM', '<=', $request->WEIGHT)
                                    ->where('WEIGHT_TO', '>', $request->WEIGHT)
                                    ->orderBy('PRICE', 'ASC')
                                    ->get();
        return response()->json($prices);
    }
}
