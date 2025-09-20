<?php

namespace App\Http\Controllers;

use App\Models\shipment;
use Illuminate\Http\Request;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\ShipmentCreated;

class ShipmentController extends Controller
{
    public function checkOrderNumber($ORDER_NUMBER) {
        $orderNumberExists = DB::table('shipments')->where('ORDER_NUMBER', '=', $ORDER_NUMBER)->get();
        if(count($orderNumberExists) > 0) {
            $ORDER_NUMBER = rand(1000000000, 9999999999);
            $this->checkOrderNumber($ORDER_NUMBER);
        }
        else 
            return $ORDER_NUMBER;
    }
    public function insertShipment(Request $request) {
        $ORDER_NUMBER = $this->checkOrderNumber($request->input('ORDER_NUMBER'));
        $shipment = new shipment();
        $shipment->ORDER_NUMBER = $ORDER_NUMBER;
        $shipment->SENDER_CODE = $request->input('SENDER_CODE');
        $shipment->SENDER_CITY = $request->input('SENDER_CITY');
        $shipment->SENDER_PROVINCE = $request->input('SENDER_PROVINCE');
        $shipment->SENDER_COUNTRY = $request->input('SENDER_COUNTRY');
        $shipment->RECEIVER_CODE = $request->input('RECEIVER_CODE');
        $shipment->RECEIVER_CITY = $request->input('RECEIVER_CITY');
        $shipment->RECEIVER_PROVINCE = $request->input('RECEIVER_PROVINCE');
        $shipment->RECEIVER_COUNTRY = $request->input('RECEIVER_COUNTRY');
        $shipment->COURIER = $request->input('COURIER');
        $shipment->PRICE = $request->input('PRICE');
        $shipment->PRICE_TYPE = $request->input('PRICE_TYPE');
        $shipment->DETAILS = $request->input('DETAILS');
        $shipment->CONTACT_DETAILS = $request->input('CONTACT_DETAILS');
        $shipment->ID_USER = $request->ID_USER;
        $shipment->save();
        return response()->json($shipment);
    }
    public function payedShipment(Request $request) {
        $shipment = DB::table('shipments')->where('ORDER_NUMBER', '=', $request->orderNumber)->get();
        $shipment = shipment::find($shipment[0]->id);
        $shipment->PAYED = 1;
        $shipment->PAYMENT_SESSION_ID = $request->payedSessionId;
        $shipment->update();
        Mail::to(json_decode($shipment->CONTACT_DETAILS)->senderEmail)->send(new ShipmentCreated($shipment));
        return response()->json($shipment);
    }
    public function updateShipment(Request $request) {
        $shipment = shipment::find($request->input('id'));
        $shipment->ORDER_NUMBER = $request->input('ORDER_NUMBER');
        $shipment->SENDER_CODE = $request->input('SENDER_CODE');
        $shipment->RECEIVER_CODE = $request->input('RECEIVER_CODE');
        $shipment->COURIER = $request->input('COURIER');
        $shipment->PRICE = $request->input('PRICE');
        $shipment->PRICE_TYPE = $request->input('PRICE_TYPE');
        $shipment->DETAILS = $request->input('DETAILS');
        // $shipment->CONTACT_DETAILS = $request->input('CONTACT_DETAILS');
        $shipment->ID_USER = $request->input('ID_USER');
        $shipment->update();
        return response()->json($shipment);
    }
    public function updateShipmentContacts(Request $request) {
        $shipment = DB::table('shipments')->where('ORDER_NUMBER', '=', explode("_", $request->orderNumber)[0])->get();
        $shipment = shipment::find($shipment[0]->id);
        $shipment->CONTACT_DETAILS = $request->input('CONTACT_DETAILS');
        $shipment->update();
        return response()->json($shipment);
    }
    public function listShipments(Request $request) {
        $shipments = shipment::all();
        $users = DB::table('users')->where('id', '<>', $request->userID)->get();
        $admin = DB::table('users')->where('id', '=', $request->userID)->get();
        return view('dashboard', ["admin" => $admin, "shipments" => $shipments, "users" => $users]);
        // return response()->json($shipments);
    }
    public function getShipment(Request $request) {
        $shipment = DB::table('shipments')->where('ORDER_NUMBER', '=', $request->orderNumber)->get();
        return response()->json($shipment);
    }
    public function getCitiesByCode(Request $request) {
        $codes = DB::table('zip_codes')->where('CODE', 'LIKE', $request->code.'%')->get();
        return response()->json($codes);
    }
}
