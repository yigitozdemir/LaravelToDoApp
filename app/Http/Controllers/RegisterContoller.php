<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class RegisterContoller extends Controller
{
    //https://www.itsolutionstuff.com/post/laravel-10-rest-api-authentication-using-sanctum-tutorialexample.html#google_vignette
    
    public function login(Request $request): JsonResponse
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } else {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function register(Request $request): JsonResponse

    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',

        ]);

   

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

   

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

   

        return $this->sendResponse($success, 'User register successfully.');

    }


    /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

    public function sendResponse($result, $message)

    {

        $response = [

            'success' => true,

            'data'    => $result,

            'message' => $message,

        ];


        return response()->json($response, 200);
    }


    /**
 
     * return error response.
 
     *
 
     * @return \Illuminate\Http\Response
 
     */

    public function sendError($error, $errorMessages = [], $code = 404)

    {

        $response = [

            'success' => false,

            'message' => $error,

        ];


        if (!empty($errorMessages)) {

            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
