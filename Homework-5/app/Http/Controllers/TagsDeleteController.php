<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsDeleteController extends Controller
{
    //
    public function execute(Tag $tag, Request $request)
    {

        if ($request->isMethod('post')) {
            $tag->delete();
            return redirect('admin')->with('status', 'Tag deleted');
        }

    }
}
