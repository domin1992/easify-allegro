@extends('layouts.master')

@section('title', 'Blog')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="blog-wrapper">
        @if(isset($blog))
          <div class="blog">
            <h2>{{ $blog->title }}</h2>
            <p><small>{{ $blog->created_at }}</small></p>
            <p>{!! $blog->text !!}</p>
          </div>
        @else
          <h5>Nie ma takiego wpisu</h5>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
