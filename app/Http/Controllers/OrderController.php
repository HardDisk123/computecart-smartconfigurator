<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Mail\OrderPlacedMail;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * ✅ SHOW CHECKOUT PAGE (GET /checkout)
     */
    public function index()
{
    if (Auth::check()) {
        // Logged in → DB cart
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with('product')->get();
    } else {
        // Guest → session cart
        $sessionCart = session()->get('cart', []);
        $items = collect($sessionCart)->map(function ($quantity, $productId) {
            $product = Product::find($productId);
            return (object)[
                'product' => $product,
                'quantity' => $quantity,
            ];
        });
    }

    return view('customer.checkout', compact('items'));
}


    /**
     * ✅ PROCESS CHECKOUT (POST /checkout)
     */
    public function checkout(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Cart is empty!');
        }

        $totalAmount = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $totalAmount,
            'status' => 'pending',
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // ✅ Clear cart after order placed
        $cart->items()->delete();

        // ✅ Send order confirmation email
        Mail::to(Auth::user()->email)->send(new OrderPlacedMail($order));

        // ✅ Redirect to home with success notification
        return redirect()->route('home')
            ->with('success', 'Your order has been placed successfully! A confirmation email has been sent to your inbox.');

    }

    /**
     * ✅ VIEW ORDER DETAILS
     */
    public function show($id)
{
    $order = Order::findOrFail($id);

    // Redirect to the profile show page, passing the order ID
    return redirect()->route('profile.show', ['profile' => $order->user_id, 'order' => $order->id]);
}

}
