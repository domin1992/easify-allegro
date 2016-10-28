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
      <h4>Poczta</h4>
      <p>
        Test e-mail
      </p>
      @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
      @endif
      <form method="post" action="{{ URL::to('/ea-admin/test-email') }}" class="form-horizontal">
        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">E-mail</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" name="email" id="email">
          </div>
        </div>
        {!! csrf_field() !!}
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-custom-orange">Wyślij</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
