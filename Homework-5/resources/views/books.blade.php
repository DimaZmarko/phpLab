@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4 filters">
                <div>
                    <h3>Books per page:</h3>
                    <form id="form-pagination" action="inc/filter.php" method="POST">
                        <input name="books_per_page" type="number" min="1" max="6" value="6">
                        <button type="submit" class="btn btn-info">Apply</button>
                    </form>
                </div>
                <div>
                    <h3>Search a book:</h3>
                    <form id="form-search" action="inc/filter.php" method="POST">
                        <input name="search" type="text" required>
                        <button type="submit" class="btn btn-info">Search</button>
                    </form>
                </div>
                <div>
                    <h3>Order by:</h3>
                    <form action="inc/filter.php" class="order_by" method="POST">
                        <p>
                            <label><input name="price_name" type="radio"
                                          value="price">Price</label>
                            <label><input name="price_name" type="radio"
                                          value="name">Name</label></p>
                    </form>
                </div>
                <div>
                    <h3>Choose tags:</h3>
                    <form action="inc/filter.php" class="form_tags" method="POST">

                    @if (isset($tags))
                        @foreach($tags as $tag)
                            <!--tags loop-->
                                <p>
                                    <label>
                                        <input type="checkbox" name="tag[{{$tag['name']}}]"
                                               value="{{$tag['name']}}">{{$tag['name']}}
                                    </label>
                                </p>
                                <!---->

                            @endforeach
                        @endif
                        <button type="submit" class="btn btn-info">Filter</button>
                    </form>

                    <form id="reset_filters" action="inc/filter.php" method="POST">
                        <input type="hidden" name="reset_filters">
                        <button type="submit" class="btn btn-danger">Reset</button>
                    </form>

                </div>
            </div>
            <div class="col-sm-8 books">
                <div class="container-fluid">

                    <div class="row message">


                        <div class="col-12">

                            <div>You have been searching the
                                <span>"SEARCH"</span>
                            </div>
                            <form action="inc/filter.php" method="POST">
                                <input name="reset_search" type="hidden">
                                <button type="submit" class="btn btn-danger">Reset results</button>
                            </form>

                            <div>Your search returned no results</div>

                        </div>

                    </div>
                    <div class="row books_list">
                        <!--Books loop-->
                        @if (isset($books))
                            @foreach ($books as $book)
                                <div class="col-12 col-md-6 d-flex" id="{{$book['isbn']}}">
                                    <div class="book_item">
                                        <h2>{{$book['name']}}</h2>

                                        <ul class="book_tags">
                                            <!--book tags loop-->

                                            @if (count($book->tags) > 0)
                                                @foreach ($book->tags as $tag)
                                                    <li>
                                                        <a href="#" data-target="{{$tag->name}}">{{$tag->name}}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                            <!---->
                                        </ul>

                                        <p class="book_image">
                                            <a target="_blank" href="">
                                                <img src="" alt="poster">
                                            </a>
                                        </p>
                                        <p class="book_url">
                                            <span>URL: </span>
                                            <a target="_blank" href="">
                                                url1
                                            </a>
                                        </p>
                                        <p class="book_price">PRICE:
                                            <span>{{$book['price']}}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!--end books loop-->
                    </div>

                    <div class="row pages_nav">

                        <ul>
                            <!--page navi-->

                            <li>
                                <a href="?page=1">&lt&lt</a>
                            </li>

                            <li>
                                <a href="?page=1">1</a>
                            </li>

                            <li><a href="?page=2">&gt&gt</a></li>
                            <!---->
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

