<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Adminove stranice
     */
    public function book(Book $book)
    {
        return view('pages/admin/book-admin');
    }
    public function books()
    {
        return view('pages/admin/books-admin');
    }

    public function orders()
    {
        return view('pages/admin/orders-admin');
    }
}
