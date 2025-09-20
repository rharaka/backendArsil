<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([UserObserver::class])]

class AuthController extends Controller
{
    public function adminRegister(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|integer'
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 0
        ]);
        // Mail::to($user)->send(new UserCreated($user->name));
        return response()->json(['user'=> $user], 201);
    }
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|integer'
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 0
        ]);
        Mail::to($user)->send(new UserCreated($user->name));
        return response()->json(['user'=> $user], 201);
    }
    public function adminLogin(Request $request) {
        $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6'
        ]);
        if($request->input('type') == 'admin') {
            if(!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Email or/and Password is incorect!'], 401);
            }
            else {
                // return response()->json(['message' => 'Admin Logged in!'], 201);
                $user = $request->user();
                if($user->role === 9) {
                    $token = $user->createToken('authToken')->plainTextToken;
                    DB::table('personal_access_tokens')->where('tokenable_id', $user->id)
                        ->update(['expires_at' => now()->addMinutes(60)]);
                    // // return redirect('/dashboard', ["user" => $user]);
                    // return redirect()->route('/dashboard', [$user]);
                    // // return view('dashboard', ["user" => $user]);
                    // return response()->json(['user' => $user, 'token' => $token]);
                    return redirect("/dashboard/{$user->id}");
                }
                else {
                    return response()->json(['message' => 'Access Role Denied!'], 401);
                }
            }
        }
        else {
            return response()->json(['message' => 'Access Type Denied!'], 401);
        }
    }
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6'
        ]);
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email or/and Password is incorect!'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('authToken')->plainTextToken;
        // $token->expires_at = now()->addMinutes(1);
        // $token->save();
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)
            ->update(['expires_at' => now()->addMinutes(60)]);
        return response()->json(['user' => $user, 'token' => $token]);
    }
    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out!']);
    }
}
