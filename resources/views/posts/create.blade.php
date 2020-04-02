@extends('layouts.app')

@section('content')

<div class="card card-default">
  <div class="card-header">
    {{ isset($post) ? 'Edit Post' : 'Create Post' }}
  </div>

  <div class="card-body">

    @include('partials.errors')

    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
      enctype="multipart/form-data">
      @csrf
      @if (isset($post))
      @method('PUT')
      @endif

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" value="{{ isset($post) ? $post->title : '' }}">
        <span class="badge form-text text-muted">Title must be unique</span>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" cols="5" rows="5"
          class="form-control">{{ isset($post) ? $post->description : '' }}</textarea>
      </div>
      <div class="form-group">
        <label for="content">Content</label>
        <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}">
        <trix-editor input="content"></trix-editor>
      </div>
      <div class="form-group">
        <label for="published_at">Published At</label>
        <input type="text" class="form-control" name="published_at" id="published_at"
          value="{{ isset($post) ? $post->published_at : '' }}">
      </div>
      @if (isset($post))
      <div class="form-group">
        <img src="{{ asset('storage/'.$post->image) }}" style="width: 100px">
      </div>
      @endif
      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" name="image">
      </div>
      <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
          @foreach ($categories as $category)
          <option value="{{ $category->id }}" @if (isset($post)) @if ($category->id===$post->category_id)
            selected
            @endif
            @endif
            >
            {{ $category->name }}
          </option>
          @endforeach
        </select>
      </div>

      @if ($tags->count() > 0 )
      <div class="form-group">
        <label for="tags">Tags</label>

        <select name="tags[]" id="tags" class="form-control tags-selector" multiple>
          @foreach ($tags as $tag)
          <option value="{{ $tag->id }}" @if (isset($post)) @if ($post->hasTag($tag->id))
            selected
            @endif
            @endif
            >
            {{ $tag->name }}
          </option>
          @endforeach
        </select>

      </div>
      @endif

      <div class="form-group">
        <button type="submit" class="btn btn-success">
          {{ isset($post) ? 'Update Post' : ' Create Post' }}
        </button>
      </div>

    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/trix.js') }}"></script>
<script src="{{ asset('js/flatpickr.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script>
  flatpickr('#published_at', {
    enableTime: true,
    enableSeconds : true,
  });

  $(document).ready(function() {
    $('.tags-selector').select2();
});
</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/trix.css') }}">
<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection