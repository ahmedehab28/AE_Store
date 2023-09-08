<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;





class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $orders = auth()->user()->orders()->with(['user', 'product'])->get();
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


    public function show(Order $order) {
        if (Gate::denies('same-user', $order) && Gate::denies('manage')) {
            abort(403);
        }

        $order->load('product', 'user');

        return view('orders.show', compact('order'));
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
    public function destroy(Order $order) {
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }
        try {
            DB::beginTransaction();
            $order->delete();

            // update user's balance
            $user = $order->user;
            $user->money += $order->quantity * $order->product->price;
            $user->save();

            // update product's quantity
            $product = $order->product;
            $product->quantity += $order->quantity;
            $product->save();

            DB::commit();
            session()->flash('status', 'Order refunded successfully!');
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            DB::rollback();
            // handle the exception
        }
    }

}
