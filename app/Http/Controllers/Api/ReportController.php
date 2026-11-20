<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;

class ReportController extends Controller
{
    public function sales()
    {
        // pesanan yang dibatalkan tidak dihitung
        $orders = Order::where('status', '!=', 'cancelled');

        return [
            'data' => [
                'total_orders' => (clone $orders)->count(),
                'books_sold'   => (int) (clone $orders)->sum('quantity'),
                'revenue'      => (int) (clone $orders)->sum('total_price'),
            ],
        ];
    }
}