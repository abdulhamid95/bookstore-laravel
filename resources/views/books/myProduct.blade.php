@extends('layouts.main')

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-5" href="{{ route('gallery.index') }}"><i class="fas fa-plus"></i> شراء كتاب جديد</a>
        <div class="d-flex row justify-content-center">
            <div class="col-md-10">
                @if ($myBooks->count())
                    @foreach ($myBooks as $book)
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12 col-xl-10">
                                <div class="card shadow-0 border rounded-3">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                        <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                            class="w-100" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-6">
                                         <h5><a href="{{ route('book.details', $book) }}">{{ $book->title }}</a></h5>
                                        <div class="d-flex flex-row">
                                            <div class="score-wrap">
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
                                        <div class="mt-1 mb-0 text-muted small">
                                            <span>{{ $book->category != null ? $book->category->name : '' }}</span>
                                            <span class="text-primary"> • </span>
                                            <span>تاريخ الشراء: {{ $book->pivot->created_at->diffForHumans()}}<br></span>
                                        </div>

                                        <p class="text-justify text-truncate para mb-0">عدد النسخ: {{ $book->pivot->number_of_copies}}<br><br></p>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                        <div class="d-flex flex-row align-items-center mb-1">
                                          <h4 class="mr-1">{{ $book->pivot->price }}$</h4>
                                    
                                        </div>
                                         <h6 class="text-success">المجموع الكلي: {{ $book->pivot->number_of_copies * $book->pivot->price}}$</h6>
                                        <div class="d-flex flex-column mt-4">
                                            <a href="{{ route('book.details', $book) }}" class="btn btn-outline-primary btn-sm" type="button">تفاصيل الكتاب</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                    @endforeach

                @else
                <div class="alert alert-danger mx-auto" role="alert">
                    لايوجد مشتريات بعد، ستجد هنا جميع المنتجات التي اشتريتها
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection