@extends('layouts.master')

@section('title', 'Załóż nowe konto')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Załóż nowe konto</h1>
      <article>
        <div class="row">
          <div class="col-sm-6">
            @if(!isset($success) || !$success)
            <form class="form-horizontal" method="post" action="{{ URL::to('/rejestracja') }}">
              <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Adres e-mail</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="@if(isset($input['email'])){{ $input['email'] }}@endif">
                </div>
              </div>
              <div class="form-group">
                <label for="pass" class="col-sm-3 control-label">Hasło</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="password" id="pass" placeholder="Hasło">
                </div>
              </div>
              <div class="form-group">
                <label for="pass-confirm" class="col-sm-3 control-label">Powtorz hasło</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="password_confirmation" id="pass-confirm" placeholder="Powtorz hasło">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <div class="g-recaptcha" data-sitekey="{{ $recaptchaPublicKey }}"></div>
                </div>
              </div>
              @if(isset($error) && $error != '')
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <div class="alert alert-danger" role="alert">{{ $error }}</div>
                </div>
              </div>
              @endif
              {!! csrf_field() !!}
              <div class="form-group">
                <div class="col-sm-12 text-right">
                  <button type="submit" class="btn btn-custom-orange">Zarejestruj</button>
                </div>
              </div>
            </form>
            @else
            <div class="alert alert-success" role="alert">Udało się zarejestrować konto, na Twój adres e-mail wysłaliśmy potwierdzenie rejestracji, wraz z linkiem weryfikującym. Kliknij na niego, aby aktywować swoje konto.</div>
            @endif
          </div>
          <div class="col-sm-6 text-center">
            <div class="bordered">
              <p>Rejestrując się akceptujesz warunki <a href="{{ URL::to('/regulamin') }}">regulaminu</a>.</p>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>
@endsection
