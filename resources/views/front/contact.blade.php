@extends('layouts.master')

@section('title', 'Kontakt')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <h2>Kontakt</h2>
      <h5>Easify Allegro Support<h5>
      <a href="mailto:support@easify-allegro.xyz">support@easify-allegro.xyz</a>
    </div>
    <div class="col-sm-6">
      <h2>Formularz kontaktowy</h2>
      @if(!isset($success) || !$success)
      <form class="form-horizontal" method="POST" action="{{ URL::to('/kontakt') }}">
        <div class="form-group">
          <label for="name" class="col-sm-4 control-label">Twoje imię i nazwisko</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="name" id="name" placeholder="Imie i nazwisko" value="@if(isset($input['name'])){{ $input['name'] }}@endif">
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-4 control-label">Twoj adres e-mail</label>
          <div class="col-sm-8">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="@if(isset($input['email'])){{ $input['email'] }}@endif">
          </div>
        </div>
        <div class="form-group">
          <label for="content" class="col-sm-4 control-label">Tresc Twojej wiadomosci</label>
          <div class="col-sm-8">
            <textarea class="form-control" name="content" id="content" placeholder="Tresc" style="height: 150px;">@if(isset($input['content'])){{ $input['content'] }}@endif</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-4 col-sm-8">
            <div class="g-recaptcha" data-sitekey="{{ $recaptchaPublicKey }}"></div>
          </div>
        </div>
        @if(isset($error) && $error != '')
        <div class="form-group">
          <div class="col-sm-offset-4 col-sm-8">
            <div class="alert alert-danger" role="alert">{{ $error }}</div>
          </div>
        </div>
        @endif
        {!! csrf_field() !!}
        <div class="form-group">
          <div class="col-sm-12 text-right">
            <button type="submit" class="btn btn-custom-orange">Wyslij</button>
          </div>
        </div>
      </form>
      @else
      <div class="alert alert-success" role="alert">Wiadomość została wysłana, postaramy się odpisać jak najszybciej</div>
      @endif
    </div>
  </div>
</div>
@endsection
