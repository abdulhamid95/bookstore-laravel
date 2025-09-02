@extends('theme.default')

@section('heading')
عرض المؤلفين
@endsection


@section('content')

    <a href="{{ route('authors.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> أضف مؤلفًا جديدًا
    </a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table id="authors-table" class="table table-striped table-bordered text-right" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الوصف</th>
                        <th>خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($authors as $author)
                        <tr>
                            <td>{{ $author->name }}</td>
                            <td>{{ $author->description }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('authors.edit', $author) }}"><i class="fa fa-edit"></i> تعديل</a>
                                <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline-block">
                                    @method("delete")
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
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
        $('#authors-table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/2.3.2/i18n/ar.json"
            }
        })
    })
    </script>
@endsection

