@extends('layouts.master')

@section('title', 'Aktywacja konta')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2>Aktywacja konta</h2>
      @if($activated)
        <div class="alert alert-success">Aktywacja konta przebiegła pomyślnie. Możesz teraz zalogować się na swoje konto.</div>
        <a href="{{ URL::to('/zaloguj') }}" class="btn btn-custom-orange">Zaloguj się</a>
      @else
        <div class="alert alert-success">Chyba coś poszło nie po Twojej myśli. Spróbuj jeszcze raz. Jeżeli problem się powtórzy, skontaktuj się z nami.</div>
        <a href="{{ URL::to('/kontakt') }}">Kontakt</a>
      @endif
  </div>
</div>
@endsection
