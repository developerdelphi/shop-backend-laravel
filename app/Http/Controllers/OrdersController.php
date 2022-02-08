<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        return $order->all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByUser(Order $order, Request $request)
    {
        return $order
            ->select('id', 'created_at', 'status', 'total')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request, Order $order)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // dd($user);
        $newOrder = $order->create([
            'user_id' => $request->user()->id,
            'total' => $request->input('total'),
            'status' => 'open',
        ]);

        if ($newOrder) {
            return response()->json(['message' => 'Created Order', 'order' => $newOrder], 201);
        } else {
            return response()->json(['message' => 'Not possible - create order'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted', 'id' => $order->id]);
    }
}
