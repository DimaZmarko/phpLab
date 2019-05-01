@extends('layouts.app')

@section('content')

    <div class="wrapper container-fluid">

        <form action="{{ route('BooksAdd') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">

                <label for="name">Book name</label>
                <div class="col-xs-8">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Book name">
                </div>

            </div>

            <div class="form-group">
                <label for="isbn">Book isbn</label>
                <div class="col-xs-8">
                    <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Book isbn">
                </div>
            </div>
            <div class="form-group">
                <label for="price">Book price</label>
                <div class="col-xs-8">
                    <input type="number" id="price" name="price" class="form-control" placeholder="Book price">
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