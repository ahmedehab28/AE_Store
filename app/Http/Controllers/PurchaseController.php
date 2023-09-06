<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;


class PurchaseController extends Controller {
    public function buy(Request $request, Product $product)
{
    try {
        // Validate the request data
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        // Calculate the total cost of the purchase
        $totalCost = $product->price * $request->input('quantity');

        // Check if the requested quantity is available
        if ($request->input('quantity') > $product->quantity) {
            // The requested quantity is not available
            return redirect()->back()->withErrors(['error' => 'The requested quantity is not available.']);
        }

        // Check if the user has enough money
        if (auth()->user()->money < $totalCost) {
            // The user does not have enough money
            return redirect()->back()->withErrors(['error' => 'You do not have enough money to make this purchase.']);
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create an order for the purchased product
            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
            ]);

            // Deduct the purchased quantity from the product's available quantity
            $product->decrement('quantity', $request->input('quantity'));

            // Deduct the total cost from the user's balance
            auth()->user()->decrement('money', $totalCost);

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // An error occurred, roll back the transaction
            DB::rollBack();

            // Rethrow the exception
            throw $e;
        }

        // Redirect the user to a confirmation page
        return redirect()->route('order.confirmation', $order);
    } catch (ValidationException $e) {
        // Handle validation errors
        if ($e instanceof ValidationException) {
            return redirect()->back()->withErrors($e->validator);
        } else {
            // Handle other exceptions
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your request. Please try again later.']);
        }
    } catch (Exception $e) {
        // Handle other exceptions
        return redirect()->back()->withErrors(['error' => 'An error occurred while processing your request. Please try again later.']);
    }
}



}
