<?php

namespace App\Http\Controllers;

use App\Models\shipment;
use App\Models\User;
use Illuminate\Http\Request;

class ShipmentUserController extends Controller
{
    public function insertShipmentUser(Request $request) {
        $shipment = new shipment();
        $shipment->ORDER_NUMBER = $request->input('ORDER_NUMBER');
        $shipment->SENDER_CODE = $request->input('SENDER_CODE');
        $shipment->RECEIVER_CODE = $request->input('RECEIVER_CODE');
        $shipment->COURIER = $request->input('COURIER');
        $shipment->PRICE = $request->input('PRICE');
        $shipment->PRICE_TYPE = $request->input('PRICE_TYPE');
        $shipment->DETAILS = $request->input('DETAILS');
        $shipment->CONTACT_DETAILS = $request->input('CONTACT_DETAILS');
        $shipment->ID_USER = $request->input('ID_USER');
        $shipment->save();
        return response()->json($shipment);
    }
    public function updateShipmentUser(Request $request) {
        $shipment = shipment::where('id', $request->input('id'))->andWhere('ID_USER', $request->input('ID_USER'));
        $shipment->ORDER_NUMBER = $request->input('ORDER_NUMBER');
        $shipment->SENDER_CODE = $request->input('SENDER_CODE');
        $shipment->RECEIVER_CODE = $request->input('RECEIVER_CODE');
        $shipment->COURIER = $request->input('COURIER');
        $shipment->PRICE = $request->input('PRICE');
        $shipment->PRICE_TYPE = $request->input('PRICE_TYPE');
        $shipment->DETAILS = $request->input('DETAILS');
        $shipment->CONTACT_DETAILS = $request->input('CONTACT_DETAILS');
        $shipment->ID_USER = $request->input('ID_USER');
        $shipment->update();
        return response()->json($shipment);
    }
    public function listShipmentsUser(Request $request) {
        $shipment = shipment::where('ID_USER', '=', $request->ID_USER)->orderBy('id', 'DESC')->get();
        return response()->json($shipment);
    }
    public function getShipmentUser(Request $request) {
        $shipment = shipment::where('ORDER_NUMBER', '=', $request->orderNumber)
                            ->where('ID_USER', '=', $request->userID)
                            ->get();
        return response()->json($shipment);
    }
}
