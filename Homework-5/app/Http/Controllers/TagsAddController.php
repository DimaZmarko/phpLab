<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Validator;

class TagsAddController extends Controller
{
    //
    public function execute(Request $request) {

        if($request->isMethod('post')) {
            $input = $request->except('_token');


            $massages = [
                'required'=>'Field :attribute is required!'
            ];


            $validator = Validator::make($input,[

                'name' => 'required|max:255'

            ], $massages);

            if($validator->fails()) {
                return redirect()->route('TagsAdd')->withErrors($validator)->withInput();
            }


            $tag = new Tag();


            $tag->fill($input);

            if($tag->save()) {
                return redirect('admin')->with('status','Tag added!');
            }

        }


        if(view()->exists('admin.tagsAdd')) {

            $data = [

                'title' => 'New Tag'

            ];
            return view('admin.tagsAdd',$data);

        }

        abort(404);


    }
}
