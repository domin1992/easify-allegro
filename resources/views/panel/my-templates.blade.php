@extends('layouts.master')

@section('title', 'Moje szablony')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1>Moje szablony</h1>
      <article>
        <div class="row">
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-4">
                <div class="template template-new">
                  <a href="{{ URL::to('/nowy-szablon') }}">
                    <div class="new-holder">
                      <h1 class="text-center"><i class="fa fa-plus-circle"></i></h1>
                      <h3 class="text-center">Dodaj nowy</h3>
                    </div>
                  </a>
                </div>
              </div>
              @if(isset($templates))
                @foreach($templates as $template)
                <div class="col-sm-4">
                  <div class="template">
                    <a href="{{ URL::to('/szablon?id='.$template->id) }}" class="template-anchor">
                      <div class="description">
                        <h3>@if($template->name != '') {{ $template->name }} @else Bez nazwy @endif</h3>
                        <p><strong>Wersja:</strong><br />{{ $template->version }}</p>
                        <p><strong>Data dodania:</strong><br />{{ date_format(new Datetime($template->created_at), 'H:i:s d.m.Y') }}</p>
                        <p><strong>Data ostatniej modyfikacji:</strong><br />{{ date_format(new Datetime($template->updated_at), 'H:i:s d.m.Y') }}</p>
                      </div>
                    </a>
                  </div>
                </div>
                @endforeach
              @endif
            </div>
          </div>
          <div class="col-sm-3">
            @if($limit->premium == 0)
            <div>
              Wykorzystany limit ({{ $limit->base_limit_used }}/{{ $limit->base_limit }})
              <div class="progress">
                <div class="progress-bar progress-bar-orange" role="progressbar" aria-valuenow="{{ $limit->base_limit_used_percent }}"
                aria-valuemin="0" aria-valuemax="100" style="width:{{ $limit->base_limit_used_percent }}%">
                  <span class="sr-only">{{ $limit->base_limit_used }}/{{ $limit->base_limit }}</span>
                </div>
              </div>
            </div>
            @endif
            @if($limit->display_premium)
            <div>
              Wykorzystany limit premium ({{ $limit->premium_limit_used }}/{{ $limit->premium_limit }})
              <div class="progress">
                <div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="{{ $limit->premium_limit_used_percent }}"
                aria-valuemin="0" aria-valuemax="100" style="width:{{ $limit->premium_limit_used_percent }}%">
                  <span class="sr-only">{{ $limit->premium_limit_used }}/{{ $limit->premium_limit }}</span>
                </div>
              </div>
            </div>
            @endif
            @if($limit->premium == 1)
            <div>
              <h4>Aktywowano konto premium, ważne do {{ date_format($limit->premium_until, 'd-m-Y H:i:s') }}</h4>
            </div>
            @endif
            @if($limit->premium == 0)
            <div>
              <a href="{{ URL::to('/zwieksz-limit') }}" class="btn btn-custom-orange">Zwiększ limit</a>
            </div>
            @endif
          </div>
        </div>
      <article>
    </div>
  </div>
</div>
@endsection
