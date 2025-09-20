<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([UserObserver::class])]

class UserController extends Controller
{
    public function insertUser(Request $request) {
        $User = new User();
        $User->name = $request->input('name');
        $User->email = $request->input('email');
        $User->password = $request->input('password');
        $User->role = $request->input('role');
        $User->save();
        Mail::to($User)->send(new UserCreated($User->name));
        return response()->json($User);
    }
    public function updateUser(Request $request) {
        $User = User::find($request->input('id'));
        $User->name = $request->input('name');
        $User->email = $request->input('email');
        $User->password = $request->input('password');
        $User->role = $request->input('role');
        $User->update();
        return response()->json($User);
    }
    public function listUsers() {
        $User = User::all();
        return response()->json($User);
    }
    public function getUserByToken(Request $request) {
        // $token = $request->bearerToken();
        $currentRequestPersonalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($request->bearerToken());
        // return $token;
        $user_id = DB::table('personal_access_tokens')->select('tokenable_id')->where('token', '=', $currentRequestPersonalAccessToken);
        $User = User::find($user_id);
        return response()->json($User);
    }
    public function getUser(Request $request) {
        $User = User::find($request->input('id'));
        return response()->json($User);
    }
    public function logout(Request $request) {
        $currentRequestPersonalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($request->bearerToken());
        // return $currentRequestPersonalAccessToken;
        $user_id = $currentRequestPersonalAccessToken->tokenable_id;
        $deleted_tokens = DB::table('personal_access_tokens')->where('tokenable_id', '=', $user_id)->delete();
        return response()->json(['message' => 'Logged out!', 'deleted_tokens' => $deleted_tokens, 'deleted_tokens_user_id' => $user_id]);
    }
}
