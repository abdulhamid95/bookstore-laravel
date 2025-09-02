@extends('theme.default')

@section('heading')
تعديل بيانات المؤلف
@endsection


@section('content')

    <div class="row justify-content-center">
        <div class="card mb-4 col-md-8">
            <div class="card-header text-right">
               عدّل بيانات المؤلف  
            </div>
            <div class="card-body">
                <form action="{{ route('authors.update', $author) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row form-group">
                        <label for="name" class="col-md-4 col-form-label text-md-right">اسم المؤلف</label>
                        <div class="col-md-6">
                            <input 
                            type="text" 
                            id="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            name="name" 
                            autocomplete="name"
                            value="{{ $author->name }}">
                            @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">الوصف</label>

                        <div class="col-md-6">
                            <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description">
                                {{ $author->description }}
                            </textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">عدل</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
