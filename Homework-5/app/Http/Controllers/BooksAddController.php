<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use Validator;

class BooksAddController extends Controller
{
    //
    public function execute(Request $request)
    {

        if ($request->isMethod('post')) {
            $input = $request->except('_token');

            $massages = [
                'required' => 'Field :attribute is required!',
                'unique' => 'Field :attribute must be unique!'
            ];


            $validator = Validator::make($input, [

                'name' => 'required|max:255',
                'isbn' => 'required|unique:books|max:255',
                'price' => 'required'

            ], $massages);

            if ($validator->fails()) {
                return redirect()->route('BooksAdd')->withErrors($validator)->withInput();
            }


            $book = new Book();

            $book->fill($input);

            if ($book->save()) {
                return redirect('admin')->with('status', 'Book added!');
            }

        }

        if (view()->exists('admin.booksAdd')) {

            $data = [

                'title' => 'New Book'

            ];
            return view('admin.booksAdd', $data);

        }

        abort(404);

    }
}
