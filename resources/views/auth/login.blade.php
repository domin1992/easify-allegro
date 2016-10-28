@extends('layouts.master')

@section('title', 'Zaloguj się')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Zaloguj się</h1>
      <article>
        <div class="row">
          <div class="col-sm-6">
            <form class="form-horizontal" method="POST" action="{{ URL::to('/zaloguj') }}">
              <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Adres e-mail</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Hasło</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Hasło">
                </div>
              </div>
              <div class="checkbox col-sm-offset-3 col-sm-9">
                <label>
                  <input type="checkbox" name="remember"> Zapamiętaj mnie
                </label>
              </div>
              @if(isset($error) && $error != '')
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <div class="alert alert-danger" role="alert">{{ $error }}</div>
                  @if(isset($activation) && $activation == 'error')
                    <p><a href="{{ URL::to('/wyslij-link-aktywacyjny?email='.$email) }}">Wyślij ponownie link aktywacyjny</a></p>
                  @endif
                </div>
              </div>
              @endif
              @if(isset($activation_sent) && $activation_sent)
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <div class="alert alert-success" role="alert">Ponownie wysłaliśmy Tobie link aktywacyjny na adres mailowy podany przy rejestracji.</div>
                </div>
              </div>
              @endif
              @if(isset($newPasswordSet) && $newPasswordSet)
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <div class="alert alert-success" role="alert">Nowe hasło zostało ustawione, zaloguj się ponownie</div>
                </div>
              </div>
              @endif
              {!! csrf_field() !!}
              <div class="form-group">
                <div class="col-sm-12 text-right">
                  <button type="submit" class="btn btn-custom-orange">Zaloguj</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-sm-6 text-center">
            <div class="bordered">
              <h5>Nie masz jeszcze konta?</h5>
              <p><a href="{{ URL::to('/rejestracja') }}" class="btn btn-custom-orange">Załóż konto</a></p>
            </div>
            <div class="bordered">
              <h5>Zapomniałeś hasło?</h5>
              <p><a href="{{ URL::to('/resetuj-haslo') }}" class="btn btn-custom-cancel">Resetuj hasło</a></p>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>

@endsection
