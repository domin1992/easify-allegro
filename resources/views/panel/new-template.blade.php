@extends('layouts.master')

@section('title', 'Nowy szablon')

@section('content')
<div class="container">
  <div class="row">
    <h1>Wgraj plik z szablonem</h1>
    <div class="col-sm-6">
      <form action="{{ URL::to('/nowy-szablon') }}" method="post" enctype="multipart/form-data">
        @if(isset($errors))
          @foreach($errors as $error)
            @foreach($error as $err)
              <div class="alert alert-danger">{{ $err }}</div>
            @endforeach
          @endforeach
        @endif
        <input type="file" name="files[]" id="filer_input">
        <p><small class="tip">Tylko pliki z rozszerzeniem html, lub htm</small></p>
        <input type="submit" value="Wyslij" id="upload-file" class="btn btn-custom-orange">
        {!! csrf_field() !!}
      </form>
    </div>
  </div>
</div>
@endsection
