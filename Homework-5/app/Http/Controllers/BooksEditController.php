<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

use Validator;

class BooksEditController extends Controller
{
    //
    public function execute(Book $book, Request $request)
    {

        if ($request->isMethod('post')) {

            $input = $request->except('_token');

            $validator = Validator::make($input, [

                'name' => 'required|max:255',
                'isbn' => 'required|max:255|unique:books,isbn,' . $input['id'],
                'price' => 'required'

            ]);

            if ($validator->fails()) {
                return redirect()
                    ->route('BooksEdit', ['book' => $input['id']])
                    ->withErrors($validator);
            }

            $book->fill($input);

            if ($book->update()) {
                return redirect('admin')->with('status', 'Book updated');
            }

        }

        $old = $book->toArray();
        if (view()->exists('admin.booksEdit')) {

            $data = [
                'title' => $old['name'],
                'data' => $old
            ];
            return view('admin.booksEdit', $data);

        }
    }
}
