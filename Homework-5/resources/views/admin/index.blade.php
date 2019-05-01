@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <div>
                        <div>Choose what you want to edit</div>
                        <div>
                            <ul style="list-style: none">
                                <li><a  href="{{route('books')}}">
                                        <h5>Books</h5>
                                    </a>
                                </li>
                                <li><a  href="{{route('tags')}}">
                                        <h5>Tags</h5>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
