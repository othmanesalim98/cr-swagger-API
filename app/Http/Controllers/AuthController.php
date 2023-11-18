<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /** @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      description="Authentify with email & password",
     *      tags={"Auth"},
     *   @OA\RequestBody(
     *       @OA\JsonContent(),
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email",type="string"),
     *               @OA\Property(property="password", type="password"),
     *           )
     *       )
     *   ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
    /** @OA\Post(
     *      path="/api/register",
     *      operationId="register",
     *      description="register with name & email and password",
     *      tags={"Auth"},
     *   @OA\RequestBody(
     *       @OA\JsonContent(),
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object",
     *               required={"name" , "email", "password" , "confirm_password"},
     *               @OA\Property(property="name",type="string"),
     *               @OA\Property(property="email", type="password"),
     *               @OA\Property(property="password",type="password"),
     *               @OA\Property(property="confirm_password", type="password"),
     * 
     *           )
     *       )
     *   ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }



     /** @OA\Get(
     *      path="/api/logout",
     *      operationId="logout",
     *      description="logout",
     *      tags={"Auth"},
     *      security={{"Bearer":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function singout()
    {
        auth()->user()->tokens()->delete();
        return $this->sendResponse([], 'Tokens Revoked');
    }
}
