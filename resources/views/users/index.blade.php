@extends('layouts.app')

@section('content')

<div class="card card-default">
  <div class="card-header">Users</div>
  <div class="card-body">

    @if ($users->count() > 0)
    <table class="table">
      <thead>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th></th>
        <th></th>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <td>
            {{-- Gravatar untuk mengambil gambar random di internet --}}
            <img src=" {{ Gravatar::src($user->email, 50) }}" class="img-thumbnail rounded-circle w-50">
          </td>
          <td class="align-middle">
            {{ $user->name }}
          </td>
          <td class="align-middle">
            {{ $user->email }}
          </td>
          <td>
            @if (!$user->isAdmin())
            <form action="{{ route('users.make-admin', $user->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-success btn-sm">Make Admin</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <h4 class="text-center">No Users yet</h4>
    @endif
  </div>
</div>
@endsection