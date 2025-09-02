@extends('theme.default')

@section('heading')
عرض االمشتريات
@endsection

@section('content')
        <div class="row">
        <div class="col-md-12">
            <table id="books-table" class="table table-striped table-bordered text-right" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>المشتري</th>
                        <th>الكتاب</th>
                        <th>السعر</th>
                        <th>عدد النسخ</th>
                        <th>السعر الإجمالي</th>
                        <th>تاريخ الشراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allBooks as $product)
                        <tr>
                            <td>{{ $product->user::find($product->user_id)->name }}</td>
                            <td><a href="{{ route('book.details', $product->book_id) }}">{{ $product->book::find($product->book_id)->title }}</a></td>
                            <td>{{ $product->price }}$</td>
                            <td>{{ $product->number_of_copies }}</td>
                            <td>{{ $product->price * $product->number_of_copies}}$</td>
                            <td>{{  $product->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
    $(document).ready(function() {
        $('#books-table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/2.3.2/i18n/ar.json"
            }
        })
    })
    </script>
@endsection