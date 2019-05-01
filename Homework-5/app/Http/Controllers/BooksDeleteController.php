<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksDeleteController extends Controller
{
    //
    public function execute(Book $book, Request $request)
    {

        if ($request->isMethod('post')) {
            $book->delete();
            return redirect('admin')->with('status', 'Book deleted');
        }

    }
}
