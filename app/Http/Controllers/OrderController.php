<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{


    public function showOrder(Order $order)
    {

        if ($order->user_id === Auth::user()->id || Auth::user()->isAdmin())
            return view(
                'pages/order',
                [
                    'order' => $order->load('user', 'orderStatus'),
                    'books' => $order->books
                ]
            );
        return Redirect::back();
    }

    public function updateOrderStatus(Order $order, Request $request)
    {

        $order->order_status_id = $request->input('order_status_id');

        if ($order->save())
            return response()->json([
                'message' => 'Uspesno promenjen status porudzbine.'
            ], 200);
        return response()->json([
            'message' => 'Greska prilikom promene statusa porudzbine.'
        ], 200);
    }

    public function getOrderStatuses()
    {

        return response()->json(['statuses' => OrderStatus::all()], 200);
    }
    public function createOrder(Request $request)
    {
        $books = $request->input('books');
        $order = Order::create([
            'order_status_id' => 1,
            'user_id' => Auth::id()
        ]);
        foreach ($books as $book) {

            if ($book['quantity'])
                DB::insert('insert into books_orders (book_id, order_id, quantity) values (?, ?, ?)', [$book['id'], $order->id, $book['quantity']]);
        }

        return response()->json(
            [
                'message' => 'Uspesno ste narucili proizvode.'
            ],
            200,
        );
    }

    public function getDatatable()
    {
    }

    public function getMyOrders()
    {
        $user = Auth::user();

        $getData = $user->orders()->with('user', 'books', 'orderStatus')->get();
        $datatable = DataTables::of($getData)->make(true);
        return $datatable;
    }

    public function getAllOrders()
    {

        $getData = Order::with('user', 'books', 'orderStatus')->get();
        $datatable = DataTables::of($getData)->make(true);
        return $datatable;
    }
}
