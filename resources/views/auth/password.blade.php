@extends('layouts.master')

@section('title', 'Resetowanie hasła')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Resetowanie hasła</h1>
      <article>
        <div class="row">
          <div class="col-sm-6">
            <form method="POST" action="/resetuj-haslo" class="form-horizontal">
              {!! csrf_field() !!}
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
                <div class="col-sm-9 col-sm-offset-3">
                  <button type="submit" class="btn btn-custom-orange">Resetuj hasło</button>
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
