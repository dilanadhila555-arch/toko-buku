<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // admin melihat semua pesanan, pembeli hanya pesanannya sendiri
        $orders = $user->role === 'admin'
            ? Order::with(['book', 'user:id,name'])->latest()->get()
            : $user->orders()->with('book')->latest()->get();

        return ['data' => $orders];
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $book = Book::findOrFail($data['book_id']);

        if ($book->stock < $data['quantity']) {
            return response()->json(['message' => 'Stok tidak cukup'], 422);
        }

        $order = $request->user()->orders()->create([
            'book_id'     => $book->id,
            'quantity'    => $data['quantity'],
            'total_price' => $book->price * $data['quantity'],
        ]);
        $book->decrement('stock', $data['quantity']);

        return response()->json(['data' => $order->load('book')], 201);
    }

    public function show(Request $request, Order $order)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Bukan pesanan Anda'], 403);
        }

        return ['data' => $order->load('book')];
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,paid,shipped,cancelled',
        ]);
        $order->update($data);

        return ['data' => $order];
    }
}