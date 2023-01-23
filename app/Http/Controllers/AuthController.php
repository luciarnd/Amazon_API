<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * description="Login",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass login info",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="text", example=""),
     *       @OA\Property(property="password", type="string", format="text", example=""),
     *    ),
     * ),
     *     @OA\Response(
     *    response=422,
     *    description="Wrong response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong data introduced")
     *        )
     *     )
     * ),
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // $request->validate();
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                /*'status' => 'error',
                'message' => 'Unauthorized',*/
                'error' => 'Unauthorized. Either email or password is wrong.',
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => env('JWT_TTL') * 60, //auth()->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/register",
     * description="Register",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass register info",
     *    @OA\JsonContent(
     *       required={"email","password", "name", "apellido", "telefono"},
     *       @OA\Property(property="email", type="string", format="text", example=""),
     *       @OA\Property(property="password", type="string", format="text", example=""),
     *         @OA\Property(property="name", type="string", format="text", example=""),
     *       @OA\Property(property="apellido", type="string", format="text", example=""),
     *      @OA\Property(property="telefono", type="string", format="text", example=""),
     *    ),
     * ),
     *     @OA\Response(
     *    response=422,
     *    description="Wrong response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong data introduced")
     *        )
     *     )
     * ),
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'apellido' => 'required',
            'telefono' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
        ]);

        //$token = Auth::login($user);
        return response()->json([
            'message' => "User successfully registered",
            'user' => $user,
        ]);
    }


    /**
     * @OA\Get(
     *      path="/api/me",
     *      tags={"Auth"},
     *      summary="See you",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function me()
    {
        return response()->json(
            Auth::user(),
        );
    }

    /**
     * @OA\Post(
     * path="/api/logout",
     * description="Logout",
     * tags={"Auth"},
     * security={{"bearerAuth":{}}},
     *     @OA\Response(
     *    response=422,
     *    description="Wrong response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong data introduced")
     *        )
     *     )
     * ),
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'User successfully signed out',
        ]);
    }
}
