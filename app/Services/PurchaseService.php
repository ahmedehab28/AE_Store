<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class PurchaseService {
    public function purchaseProduct($user, $product, $quantity) {
        // Calculate the total cost of the purchase
        $totalCost = $product->price * $quantity;

        // Check if the requested quantity is available
        if ($quantity > $product->quantity) {
            // The requested quantity is not available
            throw new Exception('The requested quantity is not available.');
        }

        // Check if the user has enough money
        if ($user->money < $totalCost) {
            // The user does not have enough money
            throw new Exception('You do not have enough money to make this purchase.');
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create an order for the purchased product
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            // Deduct the purchased quantity from the product's available quantity
            $product->decrement('quantity', $quantity);

            // Deduct the total cost from the user's balance
            $user->decrement('money', $totalCost);

            // Commit the transaction
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            // An error occurred, roll back the transaction
            DB::rollBack();

            // Rethrow the exception
            throw $e;
        }
    }
}

