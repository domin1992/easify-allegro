@extends('layouts.master')

@section('title', 'Panel administratora')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2>Panel administratora</h2>
    </div>
  </div>
  <div class="row">
    @include('admin.sidebar')
    <div class="col-sm-10">
      <h4>Użytkownicy</h4>
      <div class="table-responsive">
        <table class="table table-responsive table-hover table-striped">
          <tr>
            <th>id</th>
            <th>Email</th>
            <th>Aktywny</th>
            <th>Premium</th>
            <th>Premium do</th>
            <th>Bazowy limit</th>
            <th>Limit premium</th>
            <th>Limit premium zurzyty</th>
            <th>Limit premium skończony</th>
            <th>Utworzono</th>
            <th>Opcje</th>
          </tr>
          @forelse($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->activated }}</td>
            <td>{{ $user->premium }}</td>
            <td>{{ date_format(new DateTime($user->premium_until), 'd-m-Y H:i:s') }}</td>
            <td>{{ $user->base_limit_used }}</td>
            <td>{{ $user->premium_limit }}</td>
            <td>{{ $user->premium_limit_used }}</td>
            <td>{{ date_format(new DateTime($user->premium_limit_finished), 'd-m-Y H:i:s') }}</td>
            <td>{{ date_format(new DateTime($user->created_at), 'd-m-Y H:i:s') }}</td>
            <td><a href="{{ URL::to('/ea-admin/blog/usun-wpis/'.$user->id) }}" class="icon-bordered"><i class="fa fa-trash"></i></a></td>
          </tr>
          @empty
          <tr>
            <td colspan="6">Nie ma żadnych użytkowników</td>
          </tr>
          @endforelse
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
