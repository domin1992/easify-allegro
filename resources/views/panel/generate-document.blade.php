@extends('layouts.master')

@section('title', 'Wygeneruj dokument')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Wygeneruj dokument</h1>
      <article>
        <object data="/visualization/{{ $document->hash }}.pdf" type="application/pdf" class="pdf-visualization">
          <p>Najwyraźniej nie posiadasz wtyczki odpowiadającej za odtworzenie PDF.</p>
          <p>Spokojnie, możesz otworzyc dokument bezpośrednio <a href="/visualization/{{ $document->hash }}.pdf">tutaj</a>.</p>
        </object>
      </article>
      <article>
        <textarea class="form-control" id="document-code" style="height: 500px;" onclick="this.select()" readonly>{{ $document->content }}</textarea>
      </article>
    </div>
  </div>
</div>
@endsection
