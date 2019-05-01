@extends('layouts.app')

@section('content')
    <div style="margin:0px 50px 0px 50px;">
        @if($books)
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Name</th>
                    <th>ISBN</th>
                    <th>Price</th>
                    <th>Created At</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $k => $book)
                    <tr>
                        <td>{{$book->id}}</td>
                        <td><a href="{{route('BooksEdit',['book'=>$book->id])}}">{{$book->name}}</a></td>
                        <td>{{$book->isbn}}</td>
                        <td>{{$book->price}}</td>
                        <td>{{$book->created_at}}</td>
                        <td>
                            <form action="{{route('BooksEdit',['book'=>$book->id])}}" class="form-horizontal" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-info">Edit</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{route('BooksDelete',['book'=>$book->id])}}" class="form-horizontal" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endif

            <a href="{{route('BooksAdd')}}">New Book</a>
    </div>

@endsection