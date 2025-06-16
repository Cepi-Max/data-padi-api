<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ricesales\Order;
use App\Models\Ricesales\OrderItem;
use App\Models\Ricesales\Payment;
use App\Models\Ricesales\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'user') {
            // Ambil order user sendiri + order items-nya
            $orderdata = Order::with('orderItems.product')
                ->where('user_id', $user->id)
                ->get();

        } else if ($user->role === 'admin') {
            $adminProductIds = Product::where('user_id', $user->id)->pluck('id');
            $orderIds = OrderItem::whereIn('product_id', $adminProductIds)
                ->pluck('order_id')
                ->unique();
            $orderdata = Order::with(['orderItems.product'])
                ->whereIn('id', $orderIds)
                ->get();

        } else {
            return response()->json([
                'status' => false,
                'message' => 'Role tidak dikenali'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $orderdata
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $total_price = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $total_price += $product->price * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => $request->user_id,
            'order_code' => 'ORD-' . now()->format('YmdHis'),
            'total_price' => $total_price,
            'status' => 'pending'
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $item['quantity']
            ]);
        }

        // ==== HAPUS ITEM CART DI SINI ====
        $userCart = \App\Models\Ricesales\Cart::where('user_id', $request->user_id)->first();
        if ($userCart) {
            // Hapus semua CartItem yang sudah diorder
            $cartItemProductIds = collect($request->items)->pluck('product_id')->toArray();
            $userCart->items()->whereIn('product_id', $cartItemProductIds)->delete();
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // MIDTRANS TRANSACTION PARAMS
        $snapPayload = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => $total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'enabled_payments' => ['gopay', 'bank_transfer', 'qris'],
        ];

        $snapToken = Snap::getSnapToken($snapPayload);

        return response()->json([
            'message' => 'Order created',
            'order' => $order,
            'snap_token' => $snapToken
        ], 201);
    }

    public function show($id)
    {
        $order = Order::with('orderItems.product')->find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // kalo request hanya update status
        if ($request->has('status') && !$request->has('items')) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,shipped,delivered,,completed,cancelled'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $order->update(['status' => $request->status]);

            return response()->json(['message' => 'Status pesanan berhasil diperbarui', 'order' => $order], 200);
        }

        if ($order->status !== 'pending') {
            return response()->json(['error' => 'Pesanan sudah diproses, tidak dapat mengubah item'], 400);
        }

        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'status' => 'nullable|in:pending,paid,shipped,delivered,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        OrderItem::where('order_id', $id)->delete();

        $total_price = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $total_price += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);
        }

        // Total harga ya bos
        $order->total_price = $total_price;
        if ($request->has('status')) {
            $order->status = $request->status;
        }
        $order->save();

        return response()->json(['message' => 'Order berhasil diperbarui', 'order' => $order], 200);
    }


    public function destroy(string $id)
    {
        $dataorder = Order::findOrFail($id);

        if (in_array($dataorder->status, ['paid', 'shipped', 'delivered'])) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan tidak dapat dihapus karena sudah diproses atau sedang dikirim.'
            ], 403);
        }

        $dataorder->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.'
        ], 200);
    }


    // Process payment
    public function makePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'required|in:bank transfer,e-wallet,cod',
            'amount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $order = Order::find($request->order_id);
        if ($order->total_price != $request->amount) {
            return response()->json(['error' => 'Invalid payment amount'], 400);
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $request->user_id,
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'amount' => $request->amount,
            'transaction_id' => 'TXN-' . now()->format('YmdHis')
        ]);

        $order->update(['status' => 'paid']);

        return response()->json(['message' => 'Payment successful', 'payment' => $payment], 200);
    }
}
