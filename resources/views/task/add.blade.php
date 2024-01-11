@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header page-title-centered">
                {{ __('Add Task') }}
                <a href="{{ route('home') }}" class="text-decoration-none text-light">
                    <button class="btn btn-sm btn-success float-end"> Back </button>
                </a>
                </div>

                <div class="card-body p-0">

                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <div class="alert alert-{{ $msg }}" role="alert">
                                {{ Session::get('alert-' . $msg) }}
                            </div>
                        @endif
                    @endforeach

                    <div class="col-lg-7 m-auto mt-5 mb-5" >
                        <form action="{{ route('addTaskPost') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="mb-0 mt-2">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name='title' class="form-control" id="title" placeholder="title" value="{{ old('title') }}">
                                @if($errors->has('title'))
                                    <div class="text-danger p-2">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                            <div class="mb-0 mt-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea name='description' class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                <div class="text-danger p-2">{{ $errors->first('description') }}</div>
                                @endif
                            </div>
                            <div class="mb-0 mt-2">
                                <label for="formFile" class="form-label">Upload Image</label>
                                <input name="image" class="form-control" type="file" id="formFile">
                            </div>
                            <div class="mb-0 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
