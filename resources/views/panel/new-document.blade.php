@extends('layouts.master')

@section('title', 'Nowy dokument')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Nowy dokument</h1>
      <div class="template-list-rows">
        @forelse($templates as $template)
        <div class="template-list-item">
          <div class="row">
            <div class="col-sm-8">
              <h3>@if($template->name != '') {{ $template->name }} @else Bez nazwy @endif</h3>
              <p><strong>Wersja:</strong> {{ $template->version }}</p>
              <p><strong>Data dodania:</strong> {{ date_format(new Datetime($template->created_at), 'H:i:s d.m.Y') }}</p>
              <p><strong>Data ostatniej modyfikacji:</strong> {{ date_format(new Datetime($template->updated_at), 'H:i:s d.m.Y') }}</p>
            </div>
            <div class="col-sm-4">
              <p style="margin-top: 30px;"><a href="{{ URL::to('/utworz-dokument?id='.$template->id) }}" class="btn btn-custom-orange">Użyj tego szablonu <i class="fa fa-chevron-right"></i></a></p>
              <p><a href="{{ URL::to('/szablon?id='.$template->id) }}" class="btn btn-custom-cancel">Zobacz szablon</a></p>
            </div>
          </div>
        </div>
        @empty
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
