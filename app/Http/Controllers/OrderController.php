<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'product'])->get();
        return view('orders.index', compact('orders'));
    }

    public function confirmation(Order $order) {
        // Check if the user is authorized to view the order
        if ($order->user_id !== auth()->id()) {
            // The user is not authorized to view the order
            abort(403);
        }

        return view('orders.confirmation', compact('order'));
    }


    public function show(Order $order)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
