@extends('layouts.app')

@section('content')

    <div class="wrapper container-fluid">

        <form action="{{ route('TagsAdd') }}" class="form-horizontal" method="POST">
            @csrf
            <div class="form-group">

                <label for="name">Tag name</label>
                <div class="col-xs-8">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Tag name">
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