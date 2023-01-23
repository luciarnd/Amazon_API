<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use const http\Client\Curl\AUTH_ANY;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/miSubscription",
     *      tags={"Subscripciones"},
     *      summary="Get your subscription",
     *      description="Returns  your subscription",
     *     security={{"bearerAuth":{}}},
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
    public function index(Request $request)
    {
        $subscripcion = Subscription::where('user_id', Auth::user()->id)->get();
        return $subscripcion;
    }

    /**
     * @OA\Put(
     *      path="/api/subscription/{id}",
     *      tags={"Subscripciones"},
     *      summary="Update existing subscripcion",
     *      description="Returns updated subscripcion data",
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *     @OA\JsonContent(
     *      @OA\Property(property="", type="string", format="text", example=""),
     *    ),
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        $subscripcion = Subscription::findOrFail($id);
        $subscripcion->update($request->all());
        return $subscripcion;
    }

    /**
     * @OA\Delete(
     *      path="/api/susbcription/{id}",
     *      tags={"Subscripciones"},
     *      summary="Delete existing subscripcion",
     *      description="Deletes a record and returns no content",
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Request $request, $id)
    {
        $sub = Subscription::findOrFail($id);
        $sub->delete();
        return $sub;
    }

    /**
     * @OA\Post(
     * path="/api/subscription/",
     * description="Add subscripcion",
     * tags={"Subscripciones"},
     *     security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass pedido info",
     *    @OA\JsonContent(
     *       required={"plan","fechainicio", "fechacaducidad"},
     *       @OA\Property(property="direccion", type="string", format="text", example=""),
     *       @OA\Property(property="fechainicio", type="string", format="text", example=""),
     *         @OA\Property(property="fechacaducidad", type="string", format="text", example=""),
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan' => 'required|max:255',
            'fechainicio' => 'required|string',
            'fechacaducidad' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $user = Auth::user()->id;
        $sub = new Subscription($input);
        $sub->user()->associate($user);
        $sub->save();
        return $sub;
    }

}
