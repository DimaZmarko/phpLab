<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use App\Tag;

class IndexController extends Controller
{
    //

    public function execute(Request $request)
    {
        $books = Book::with('tags')->get();
        $tags = Tag::get(array('name'));

        //dd($books);

        return view('books', ['books' => $books, 'tags' => $tags]);
    }
}
