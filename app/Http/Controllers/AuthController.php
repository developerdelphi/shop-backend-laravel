<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        Auth::loginUsingId($user->id);

        $token = $user->createToken('shop')->plainTextToken;

        $response = [
            'message' => 'User authenticated',
            'user' => $user,
            'token' => $token
        ];


        return response()->json($response, 201);
    }

    public function signout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sing out with success']);
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        /**
         *  Login via token
         **/

        // $user = User::where('email', $credentials['email'])->first();

        // if (!!$user || Hash::check($credentials['password'], $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['The provide credentials are incorret.']
        //     ]);
        // }

        // $token = $request->user()->createToken('shop')->plainTextToken;


        // $response = [
        //     'message' => 'User authenticated',
        //     'user' => $user,
        //     'token' => $token
        // ];

        // return response()->json($response, 200);


        /**
         * Login via session
         * */

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $response = [
                'message' => 'User authenticated',
                'user' => Auth::user(),
            ];

            return response()->json($response, 200);
        }

        return response()->json(['message' => 'Credentials not accepted.'], 401);
    }
}
