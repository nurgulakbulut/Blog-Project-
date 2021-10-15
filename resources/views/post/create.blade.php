@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('New Post') }}

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form action="{{ route('posts.store') }}" method="POST">
                         @csrf
                        <div class="form-group">
                           <label for="slcCategory"> {{ __('Post Category') }} </label>
                           <select class="custom-select" name="category_id">
                               @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                           <label for="inpTitle"> {{ __('Post Title') }} </label>
                           <input type="text"  name="title" class="form-control" id="inpTitle" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="txtContent">{{ __('Post Content') }}</label>
                            <textarea name="content" class="form-control" id="txtContent">{{ old('content') }}</textarea>
                        </div>
                        <div class="form-group">
                           <label for="inpTags"> {{ __('Post Tags') }} </label>
                           <input type="text"  name="tags" class="form-control" id="inpTags" value="{{ old('tags') }}"
                            aria-describedby="tagsHelp">
                            <small id="tagsHelp" class="form-text text-muted">{{ __('Seperate with commas.') }}</small>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create Post') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
