<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PageController extends Controller
{

    /**
     * Korisnikove stranice
     */
    public function book(Book $book)
    {
        return view('pages/user/book-user');
    }
    public function books()
    {
        return view('pages/user/books-user');
    }
    public function cart()
    {
        return view('pages/user/cart-user');
    }

    public function myOrders()
    {
        return view('pages/user/my-orders-user');
    }



}
