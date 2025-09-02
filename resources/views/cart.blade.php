@extends('layouts.main')

@section('content')
    <div class="conatiner">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">عربة التسوق</div>
                     <div class="card-body">
                        @if ($items->count())
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">العنوان</th>
                                        <th scope="col">السعر</th>
                                        <th scope="col">الكمية</th>
                                        <th scope="col">السعر الكلي</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                @php($totalPrice = 0)
                                @foreach ($items as $item)
                                    @php($totalPrice += $item->price * $item->pivot->number_of_copies)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $item->title }}</th>
                                            <td>{{ $item->price }} $</td>
                                            <td>{{ $item->pivot->number_of_copies }}</td>
                                            <td>{{ $item->price * $item->pivot->number_of_copies }} $</td>
                                            <td>
                                                <form style="float:left; margin: auto 5px" method="post" action="{{ route('cart.remove_all', $item->id) }}">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" type="submit">أزل الكل</button>
                                                </form>
                                                <form style="float:left; margin: auto 5px" method="post" action="{{ route('cart.remove_one', $item->id) }}">
                                                    @csrf
                                                    <button class="btn btn-warning btn-sm" type="submit">أزل واحدًا</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                             <h4>المجموع النهائي: {{ $totalPrice }} $</h4>
                             <a href="{{ route('credit.checkout')}}" class="d-inline-block mb-4 float-left btn bg-cart" style="text-decoration:none;">
                                <span>بطاقة ائتمانية</span>
                                <i class="fas fa-credit-card"></i>
                            </a>
                        @else
                         <h1>لا يوجد كتب في العربة</h1>
                        @endif
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection 