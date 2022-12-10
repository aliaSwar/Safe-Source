<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validetor = Validator::make($request->all(), [
            'email'        =>        'required|email|unique:users,email',
            'name'         =>        'required|string|max:255',
            'password'     =>        'required|string|max:255'
        ]);

        if ($validetor->fails()) {
            return  $validetor->errors()->all();
            //$this->formatValidationErrors($validetor);
        }

        $user = User::create([
            'name'            =>       $request->name,
            'email'           =>       $request->email,
            'password'        =>       Hash::make($request->password)
        ]);

        $token = $user->createToken('auth')->plainTextToken;

        return [
            'message'   =>      'Sucsess Register ',
            'user'      =>      $user,
            'token'     =>      $token
        ];
    }
    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validetor = Validator::make($request->all(), [
            'name'         =>        'required|string|max:255',
            'password'     =>        'required|string|max:255'
        ]);

        if ($validetor->fails()) {
            return  $validetor->errors()->all();
            // $this->formatValidationErrors($validetor);
        }

        if (Auth::attempt($request->all())) {
            //he is a real user
            $user = $request->user();

            $token = $user->createToken('auth')->plainTextToken;


            $response = [
                'user'        =>   $user,
                'token'       =>   $token
            ];

            return $response;
        }
    }
    /**
     * logout user
     */
    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return ['message' => 'Successfully logged out'];
    }
}
