<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\PurchaseService;
use Exception;

use Illuminate\Support\Facades\Gate;



class PurchaseController extends Controller {
    public function buy(Request $request, Product $product) {
        if (Gate::allows('manage')) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');

        }
        try {
            // Validate the request data
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $product->quantity,
            ]);

            // Create an instance of the PurchaseService
            $purchaseService = new PurchaseService();

            // Purchase the product using the PurchaseService
            $order = $purchaseService->purchaseProduct(auth()->user(), $product, $request->input('quantity'));

            // Redirect the user to a confirmation page
            return redirect()->route('order.confirmation', $order->id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
