<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ricesales\Product;
use App\Models\Ricesales\Order;
use App\Models\Ricesales\OrderItem;
use App\Models\Ricesales\Payment;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // List all orders
    public function index()
    {
        $orderdata = Order::all();
         
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $orderdata
        ], 200);
    }

    // Create new order
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
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => Product::find($item['product_id'])->price,
                'subtotal' => Product::find($item['product_id'])->price * $item['quantity']
            ]);
        }

        return response()->json(['message' => 'Order created', 'order' => $order], 201);
    }

    // Get order details
    public function show($id)
    {
        $order = Order::with('orderItems.product')->find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return response()->json($order, 200);
    }

    // Update pesanan kalo status pending saja
    public function update(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('status', 'pending')->first();

        if (!$order) {
            return response()->json(['error' => 'Order sedang diproses, tidak dapat diubah'], 400);
        }

        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Hapus order_items lama
        OrderItem::where('order_id', $id)->delete();

        $total_price = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $total_price += $product->price * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $item['quantity']
            ]);
        }

        $order->update(['total_price' => $total_price]);

        return response()->json(['message' => 'Order berhasil diperbarui', 'order' => $order], 200);
    }

    public function destroy(string $id)
    {
        //
        $dataorder = Order::findOrFail($id);

        $dataorder->delete();

        return response()->json([
            'status' => true,
            'message' => 'data berhasil dihapus'
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
