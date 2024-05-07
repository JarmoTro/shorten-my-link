<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    function getLoginRegisterPage(Request $request){

        return view('auth.login-register');

    }

    function login(Request $request){

         $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'email' => 'required',
            'password' => 'required',
        ],
        [
            "email.required" => "Please enter your email.",
            "password.required" => "Please enter your password.",
        ]);

        if(!$validator->passes()){
            return response()->json(["errors" => $validator->errors()->all(), "success" => false], 400);
        }

        $isAuthenticated = auth()->attempt(array('email' => $inputs['email'], 'password' => $inputs['password']));

        if(!$isAuthenticated){
            return response()->json(["errors" => ["Invalid credentials."], "success" => false], 401);
        }

        return response()->json(["errors" => [], "success" => true], 200);
    }

    function register(Request $request){
        
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            "email" => "required|max:250|email",
            "password" => "required|max:250"
        ],
        [
            "email.required" => "Please enter your email.",
            "email.max" => "Email must be less than 250 characters long.",
            "email.email" => "Email is not a valid email address.",
            "password.required" => "Please enter your password.",
            "password.max" => "Password must be less than 250 characters long.",
        ]);

        $errors = [];

        if(!$validator->passes()){
            $errors = $validator->errors()->all();
        }

        if(User::where("email", "=", $inputs["email"])->exists()){
            $errors[] = "This email address is already in use.";
        }

        if(!empty($errors)){
            return response()->json(["errors" => $errors, "success" => false], 400);
        }

        $email = $inputs["email"];

        $password = $inputs["password"];

        $registered_user = new User();

        $registered_user->name = $email;

        $registered_user->email = $email;

        $registered_user->password = $password;

        $registered_user->save();

        return response()->json(["errors" => $errors, "success" => true], 201);
    }

}