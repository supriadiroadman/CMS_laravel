@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
  <a href="{{ route('posts.create') }}" class="btn btn-success">Add Post</a>
</div>

<div class="card card-default">
  <div class="card-header">Posts</div>
  <div class="card-body">

    @if ($posts->count() > 0)
    <table class="table">
      <thead>
        <th>Image</th>
        <th>Title</th>
        <th>Category</th>
        <th></th>
        <th></th>
      </thead>
      <tbody>
        @foreach ($posts as $post)
        <tr>
          <td>
            <img src="{{ asset('storage/'.$post->image) }}" width="100px" alt="">
          </td>
          <td class="align-middle">
            {{ $post->title }}
          </td>
          <td class="align-middle">
            <a href="{{ route('categories.edit', $post->category->id) }}">
              {{$post->category->name}}
            </a>
          </td>
          @if ($post->trashed())
          <td class="align-middle">
            <form action="{{ route('restore-posts', $post->id) }}" method="POST">
              @csrf
              @method('PUT')
              <button type="submit" class="btn btn-info btn-sm">Restore</button>
            </form>
          </td>
          @else
          <td class="align-middle">
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info btn-sm">Edit</a>
          </td>
          @endif
          <td class="align-middle">
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">
                {{ $post->trashed() ? 'Delete' : 'Trash' }}
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <h4 class="text-center">No Post yet</h4>
    @endif
  </div>
</div>
@endsection