@extends('layouts.main')

@section('head')
    <style>
    .card .card-body .card-title {
        height: 40px;
        overflow: hidden;
        font-size: 17px;
    }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <form action="{{ route('search') }}" method="GET">
                    <div class="row d-flex justify-content-center">
                        <input type="text" class="col-3 mx-sm-3 mb-2" name="term" placeholder="ابحث عن كتاب...">
                        <button type="submit" class="col-1 btn btn-secondary bg-secondary mb-2">ابحث</button>
                    </div>
                </form>
                <h3 class="mb-3">
                    {{$title}}
                </h3>
            </div>
        </div>
        <div class="row">
            @if ($books->count())
                @foreach ($books as $book)
                    @if ($book->number_of_copies > 0)
                        <div class="col-lg-3 col-md-4 col-sm-6 mt-2">
                            <div class="card mb-3" style="max-width: 320px">
                                <a href="{{ route('book.details', $book )}}">
                                    <img src="{{asset('storage/' . $book->cover_image )}}" width="96" height="350" class="card-img img_fluid" alt="Product Image">
                                </a>
                                
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('book.details', $book )}}" class="text-default mb-0">
                                            {{ $book->title }}
                                        </a>
                                    </h5>
                                    @if ($book->category != NULL)
                                        <a href="{{ route('gallery.categories.show', $book->category )}}" class="text-muted">
                                                {{ $book->category->name }} 
                                        </a>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0">{{ $book->price }} $</span>
                                        <div>
                                            <span class="score">
                                                <div class="score-wrap">
                                                    <span class="stars-active" style="width:{{ $book->rate()*20 }}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
                                                    <span class="stars-inactive">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <h3 style="margin:0 auto">لا نتائج</h3>
            @endif
        </div>
        {{ $books->links() }}
    </div>
@endsection