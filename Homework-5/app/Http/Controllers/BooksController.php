<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    //
    public function execute()
    {
        if(view()->exists('admin.books')) {
            $books = Book::all();

            $data = ['title' => 'Books', 'books' => $books];

            return view('admin.books', $data);
        }

    }
}
