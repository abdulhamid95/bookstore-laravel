@extends('theme.default')

@section('heading')
عرض المستخدمين
@endsection


@section('content')

    <hr>
    <div class="row">
        <div class="col-md-12">
            <table id="users-table" class="table table-striped table-bordered text-right" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>نوع المستخدم</th>
                        <th>خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{$user->isSuperAdmin() ? 'مدير عام' : ($user->isAdmin() ? 'مدير' : 'مستخدم عادي') }}</td>
                            <td>
                                <form action="{{ route('users.update', $user) }}" class="ml-4 form-inline d-inline-block" method="POST">
                                    @method('patch')
                                    @csrf
                                    <select class="form-control form-control-sm" name="administration_level">
                                        <option selected disabled>اختر نوعًا</option>
                                        <option value="0">مستخدم</option>
                                        <option value="1">مدير</option>
                                        <option value="2">مدير عام</option>
                                        
                                    </select>
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> تعديل</button>
                                </form>
                                <form action="{{ route('users.destroy', $user) }}" style="display:inline-block" method="POST">
                                    @method('delete')
                                    @csrf
                                    @if (auth()->user() != $user)
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')"><i class="fa fa-trash"></i> حذف</button>
                                    @else
                                        <div class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> حذف </div>
                                    @endif
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
        $('#users-table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/2.3.2/i18n/ar.json"
            }
        })
    })
    </script>
@endsection

