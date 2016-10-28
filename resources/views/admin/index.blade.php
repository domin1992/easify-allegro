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
      <h4>Administracja</h4>
  </div>
</div>
@endsection
