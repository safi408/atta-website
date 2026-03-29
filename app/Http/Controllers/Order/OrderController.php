<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
       /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with('customer')->orderBy('created_at', 'desc')->get();
        $customers = Customer::where('status', 'Active')->orderBy('name')->get();
        
        return view('Backend.Order.index', compact('orders', 'customers'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,delivered',
            'note' => 'nullable|string|max:1000',
        ], [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'Selected customer does not exist.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be at least 1.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'total.required' => 'Total amount is required.',
            'status.required' => 'Order status is required.',
            'status.in' => 'Please select a valid order status.',
            'note.max' => 'Note cannot exceed 1000 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create the order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $request->total,
                'status' => $request->status,
                'note' => $request->note,
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' added successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to save order. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('customer')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $order->id,
                'order_id' => '#ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'customer_id' => $order->customer_id,
                'customer_name' => $order->customer ? $order->customer->name : 'N/A',
                'customer_email' => $order->customer ? $order->customer->email : 'N/A',
                'customer_phone' => $order->customer ? $order->customer->phone : 'N/A',
                'quantity' => $order->quantity,
                'price' => $order->price,
                'total' => $order->total,
                'status' => $order->status,
                'note' => $order->note,
                'created_at' => $order->created_at->format('d M Y, h:i A'),
                'created_date' => $order->created_at->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the order
        $order = Order::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,delivered',
            'note' => 'nullable|string|max:1000',
        ], [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'Selected customer does not exist.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be at least 1.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'total.required' => 'Total amount is required.',
            'status.required' => 'Order status is required.',
            'status.in' => 'Please select a valid order status.',
            'note.max' => 'Note cannot exceed 1000 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update the order
            $order->update([
                'customer_id' => $request->customer_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $request->total,
                'status' => $request->status,
                'note' => $request->note,
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update order. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $orderId = '#ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
            $order->delete();

            return redirect()->route('orders.index')
                ->with('success', 'Order ' . $orderId . ' deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Failed to delete order. Please try again.');
        }
    }


  
}
