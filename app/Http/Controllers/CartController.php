<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\DB;
use App\Services\PurchaseService;

use App\Models\Product;

class CartController extends Controller
{
    public function index() {
        $cartItems = Cart::getContent();
        return view('cart.index', compact('cartItems'));
    }


    public function add($id) {
        $product = Product::find($id);
        $cartItem = Cart::get($id);

        // Check if the product is in stock
        if ($product->quantity < 1) {
            // Display an error message and redirect back
            return redirect()->back()->with(['error' => 'This product is out of stock.']);
        }

        // Check if the cart already contains this item
        if ($cartItem) {
            // The cart already contains this item
            // Check if there is enough quantity available
            if ($product->quantity <= $cartItem->quantity) {
                // There is not enough quantity available
                // Display an error message and redirect back
                return redirect()->back()->with(['error' => 'There is not enough quantity available for this product.']);
            }
        }

        // Add the product to the cart
        Cart::add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
        ));

        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

    public function removeItem ($id) {
        Cart::remove($id);
        return redirect()->back()->with('success', 'Item removed successfully!');
    }

    public function removeOne($id) {
        // Get the item from the cart
        $item = Cart::get($id);

        // Check if the item exists and has more than one quantity
        if ($item && $item->quantity > 1) {
            // Update the item's quantity in the cart
            Cart::update($id, array(
                'quantity' => -1, // this will decrement the quantity by 1
            ));
            return redirect()->back()->with('success', 'Retruned one back successfully!');
        } else {
            // Remove the item from the cart
            Cart::remove($id);
            return redirect()->back()->with('success', 'Item removed successfully!');
        }
    }

    public function buy() {
        $cartItems = Cart::getContent();
        $user = auth()->user();

        // Create an instance of the PurchaseService
        $purchaseService = new PurchaseService();

        DB::beginTransaction();

        try {
            foreach ($cartItems as $item) {
                // Get the product associated with the cart item
                $product = Product::find($item->id);

                // Purchase the product using the PurchaseService
                $purchaseService->purchaseProduct($user, $product, $item->quantity);
            }

            // Clear the cart
            Cart::clear();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('orders.index', $user->id)->with('success', 'Your items were ordered successfully');
    }




}