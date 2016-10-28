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
      <h4>Aktywacja pakietu</h4>
      @if(isset($error) && $error != '')
        <div class="alert alert-danger">{{ $error }}</div>
      @endif
      <div class="table-responsive">
        <table class="table table-responsive table-hover table-striped">
          <tr>
            <th>id</th>
            <th>Użytkownik</th>
            <th>Adres</th>
            <th>Metoda</th>
            <th>Pakiet</th>
            <th>Kwota</th>
            <th>Potwierdzony</th>
            <th>Utworzono</th>
            <th>Opcje</th>
          </tr>
          @forelse($declarations as $declaration)
          <tr>
            <td>{{ $declaration->id }}</td>
            <td>{{ $declaration->user }}</td>
            <td>{{ $declaration->userWalletAddress }}</td>
            <td>{{ $declaration->method }}</td>
            <td>{{ $declaration->package }}</td>
            <td>
              @if($declaration->method == 'bitcoin')
                {{ $declaration->price }} BTC
              @elseif($declaration->method == 'paypal')
                {{ $declaration->price }} zł
              @endif
            </td>
            <td>
              @if($declaration->confirmation == 1)
                Tak
              @elseif($declaration->confirmation == 0)
                Nie
              @endif
            </td>
            <td>{{ date_format(new DateTime($declaration->created_at), 'd-m-Y H:i:s') }}</td>
            <td>
              @if($declaration->confirmation == 0)
                <a href="{{ URL::to('/ea-admin/aktywuj-pakiet/aktywuj/'.$declaration->id) }}" class="icon-bordered"><i class="fa fa-check"></i></a>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6">Nie ma żadnych deklaracji</td>
          </tr>
          @endforelse
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
