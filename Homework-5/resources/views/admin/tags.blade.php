@extends('layouts.app')

@section('content')
    <div style="margin:0px 50px 0px 50px;">
        @if($tags)
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $k => $tag)
                    <tr>
                        <td>{{$tag->id}}</td>
                        <td><a href="{{route('TagsEdit',['tag'=>$tag->id])}}">{{$tag->name}}</a></td>
                        <td>{{$tag->created_at}}</td>
                        <td>
                            <form action="{{route('TagsEdit',['tag'=>$tag->id])}}" class="form-horizontal" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-info">Edit</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{route('TagsDelete',['tag'=>$tag->id])}}" class="form-horizontal" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endif

        <a href="{{route('TagsAdd')}}">New Tag</a>
    </div>

@endsection