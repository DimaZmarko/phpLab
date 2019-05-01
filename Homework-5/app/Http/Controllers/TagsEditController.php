<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

use Validator;

class TagsEditController extends Controller
{
    //
    public function execute(Tag $tag, Request $request)
    {
        if ($request->isMethod('post')) {

            $input = $request->except('_token');

            $validator = Validator::make($input, [

                'name' => 'required|max:255',

            ]);

            if ($validator->fails()) {
                return redirect()
                    ->route('TagsEdit', ['tag' => $input['id']])
                    ->withErrors($validator);
            }

            $tag->fill($input);

            if ($tag->update()) {
                return redirect('admin')->with('status', 'Tag updated');
            }

        }

        $old = $tag->toArray();
        if (view()->exists('admin.tagsEdit')) {

            $data = [
                'title' => $old['name'],
                'data' => $old
            ];
            return view('admin.tagsEdit', $data);

        }

    }
}
