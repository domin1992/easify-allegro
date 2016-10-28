@extends('layouts.master')

@section('title', 'Nowe hasło')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Nowe hasło</h1>
      <article>
        <div class="row">
          <div class="col-sm-6">
            <form method="POST" action="/nowe-haslo" class="form-horizontal">
              {!! csrf_field() !!}
              <input type="hidden" name="token" value="{{ $token }}">
              <div class="form-group">
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
              </div>
              <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Adres e-mail</label>
                <div class="col-sm-9">
                  <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Hasło</label>
                <div class="col-sm-9">
                  <input type="password" id="password" name="password" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="password_confirmation" class="col-sm-3 control-label">Powtórz hasło</label>
                <div class="col-sm-9">
                  <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                  <button type="submit" class="btn btn-custom-orange">Potwierdź</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>
@endsection
