<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user) {
        if (Gate::allows('same-user', $user) && Gate::allows('manage')) {
            return redirect()->route('orders.all');
        }

        if (Gate::allows('same-user', $user) || Gate::allows('manage')) {
            $orders = Order::where('user_id', $user->id)->with(['user', 'product'])->orderBy('created_at', 'desc')->get();
            return view('orders.index', compact('orders'));
        } else {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
    }

    public function allOrders () {
        // authorization and admin role checking is handled in web.php
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('orders.admin.index', compact('orders'));
    }


    public function confirmation(Order $order) {
        // Check if the user is authorized to view the order
        if (Gate::denies('same-user-order', $order) && Gate::denies('manage')) {
            // The user is not authorized to view the order
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        return view('orders.confirmation', compact('order'));
    }


    public function show(Order $order) {
        if (Gate::denies('same-user-order', $order) && Gate::denies('manage')) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        $order->load('product', 'user');

        return view('orders.show', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order) {
        if (Gate::denies('same-user', $order->user) && Gate::denies('manage')) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
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
            return redirect()->route('orders.index',$user->id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
