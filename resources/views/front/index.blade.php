@extends('layouts.master')

@section('content')
<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="text-center uppercase">Ułatw sobie życie</h1>
        <h4 class="text-center">Z aplikacją Easify Allegro nie musisz po raz prosić kolejny web developera o przygotowanie strony Allegro nowego produktu. Od dziś samodzielnie możesz uzupełnić swój szablon treścią</h4>
        <p class="text-center">Poznaj niezwykle możliwości, których nie znajdziesz nigdzie indziej</p>
        <p class="text-center"><a href="{{ URL::to('/rejestracja') }}" class="btn btn-big btn-custom-orange">Załóż konto</a></p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="text-center uppercase">Jesteś Web Deweloperem?</h2>
        <h4 class="text-center">Udostępniaj swoim klientom szablony. Masz do nich cały czas wgląd i możesz je modyfikować. Twój klient będzie miał na swoim koncie zaktualizowany szablon zaraz po tym jak wyślesz nowa wersje do serwisu</h4>
      </div>
    </div>
  </div>
</section>
<section class="even">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h4>Najnowsze wpisy bloga</h4>
        <div class="row">
          @forelse($blogs as $blog)
          <div class="col-sm-6">
            <h5><a href="{{ URL::to('/blog/'.$blog->id) }}">{{ $blog->title }}</a></h5>
            <p><small>{{ $blog->created_at }}</small></p>
            <p>{{ str_limit(strip_tags($blog->text), 150, '...') }}</p>
          </div>
          @empty
          <p class="col-sm-12">Jeszcze nie ma żadnych wpisów.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <p class="text-center">
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Vertical for EA -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-2180140997733350"
     data-ad-slot="2972842821"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </p>
      </div>
    </div>
  </div>
</section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="text-center">Dowiedz się jak działa serwis</h2>
        <p class="text-center"><a href="{{ URL::to('/jak-dziala') }}" class="btn btn-big btn-custom-orange">Jak działa</a></p>
      </div>
    </div>
  </div>
</section>
@endsection
