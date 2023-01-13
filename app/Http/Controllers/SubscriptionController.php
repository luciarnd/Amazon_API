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

    public function index(Request $request)
    {
        $subscripcion = Subscription::where('user_id', Auth::user()->id)->get();
        return $subscripcion;
    }

    public function update(Request $request, $id)
    {
        $subscripcion = Subscription::findOrFail($id);
        $subscripcion->update($request->all());
        return $subscripcion;
    }

    public function destroy(Request $request, $id)
    {
        $sub = Subscription::findOrFail($id);
        $sub->delete();
        return $sub;
    }

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
