<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Item;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validation->fails()) {
            $response = [
                'success' => false,
                'message' => $validation->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['name'] = $user->name;
        $success['email'] = $user->email;
        $success['token'] = $user->createToken('MyApp')->plainTextToken;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully'
        ];

        return response()->json($response, 200);
    }


    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['token'] = $user->createToken('MyApp')->plainTextToken;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully'
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorised'
            ];
            return response()->json($response);
        }
    }


    public function item(Request $request)
    {
        // dd($request->all());
        $itemArray = [];
        foreach ($request->all() as $item) {

            $addItem = Item::create([
                'name' => $item['name'],
                'price' => $item['price']
            ]);
            array_push($itemArray, $addItem);
        }
        $response = [
            'success' => true,
            'data' => $itemArray,
            'message' => 'Item created successfully'
        ];

        return response()->json($response, 200);
    }
}