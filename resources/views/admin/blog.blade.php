@extends('layouts.master')

@section('title', 'Wpis')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      @if(isset($blog))
        <h2>Wpis</h2>
      @else
        <h2>Nowy wpis</h2>
      @endif
      <form method="post" action="{{ URL::to('/ea-admin/blog/wpis') }}" class="form">
        <div class="form-group">
          <input type="text" class="form-control" id="title" name="title" placeholder="Tytuł" value="@if(isset($blog)){{ $blog->title }}@endif">
        </div>
        <div class="form-group">
          <textarea id="wysiwyg" name="content">@if(isset($blog)){{ $blog->text }}@endif</textarea>
        </div>
        @if(isset($blog))
          <input type="hidden" name="blog_id" value="{{ $blog->id }}">
        @endif
        {!! csrf_field() !!}
        <div class="form-group">
          <div class="col-sm-6">
            <a href="{{ URL::to('/ea-admin/blog') }}" class="btn btn-custom-cancel">Wstecz</a>
          </div>
          <div class="col-sm-6 text-right">
            <button type="submit" class="btn btn-custom-orange">Zapisz</button>
          </div>
        </div>
      </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/new-blog.js') }}"></script>
@endsection
