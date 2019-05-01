<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    //
    public function execute()
    {
        if(view()->exists('admin.tags')) {
            $books = Tag::all();

            $data = ['title' => 'Tags', 'tags' => $books];

            return view('admin.tags', $data);
        }

    }
}
