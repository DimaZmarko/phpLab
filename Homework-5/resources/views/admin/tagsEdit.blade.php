@extends('layouts.app')

@section('content')

    <div class="wrapper container-fluid">

        <form action="{{ route('TagsEdit', array('tag' => $data['id'])) }}" class="form-horizontal" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $data['id'] }}">

            <div class="form-group">

                <label for="name">Tag name</label>
                <div class="col-xs-8">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Tag name" value="{{ $data['name'] }}">
                </div>

            </div>

            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>

    </div>

@endsection