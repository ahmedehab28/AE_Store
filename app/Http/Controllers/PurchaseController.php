<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class PurchaseController extends Controller {
    public function buy(Request $request, Product $product) {
        // Validate the request data
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        // Calculate the total cost of the purchase
        $totalCost = $product->price * $request->input('quantity');

        // Check if the user has enough money
        if (auth()->user()->balance->amount < $totalCost) {
            // The user does not have enough money
            return redirect()->back()->withErrors(['error'=>'You do not have enough money to make this purchase.']);
        }

        // Deduct the purchased quantity from the product's available quantity
        $product->decrement('quantity', $request->input('quantity'));

        // Deduct the total cost from the user's balance
        auth()->user()->balance->decrement('amount', $totalCost);

        // Create an order for the purchased product
        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->input('quantity'),
            'total_price' => $totalCost,
        ]);

        // Redirect the user to a confirmation page
        return redirect()->route('order.confirmation', $order);
    }

}
