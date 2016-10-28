<!DOCTYPE html>
<html>
<head>
  <title>@if (trim($__env->yieldContent('title')))@yield('title') | @endif Easify Allegro</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google -->
  <meta name="description" content="Easify Allegro jest aplikacją internetową służącą do szybkiej podmiany treści w szablonach allegro. Wystarczy, że dobrze przygotowany szablon zostanie wysłany na serwer poprzez panel użytkownika. System samodzielnie zweryfikuje, w którym miejscu mają zostać podmienione dane i pozwoli użytkownikowi na wypełnienie go treściami przez wypełnienie pól tekstowych w panelu użytkownika." />
  <!-- /Google -->
  <!-- Facebook -->
  <meta property="og:site_name" content="Easify Allegro" />
  <meta property="og:title" content="Easify Allegro - Ułatwienie dla Allegrowiczów, zmieniaj szybko treści na swojej aukcji allegro" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="http://easify-allegro.xyz" />
  <meta property="og:image" content="{{ URL::asset('img/ea_logo_fb.png') }}" />
  <meta property="fb:app_id" content="966242223397117" />
  <!-- /Facebook -->
  <!-- Twitter -->
  <meta name="twitter:card" content="app" />
  <meta name="twitter:site" content="" />
  <meta name="twitter:creator" content="@Domin1992" />
  <!-- /Twitter -->
  <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon.png') }}" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ URL::asset('plugins/jQuery.filer/css/jquery.filer.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('plugins/jQuery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
  @yield('stylesheets')
</head>
<body>
  <header>
    <div class="container">
      <div class="row flex">
        <div class="col-sm-4 flex-item">
          <p class="brand"><a href="{{ URL::to('/') }}"><span class="logo-holder"><img src="{{ URL::asset('img/ea_logo_small.png') }}" alt="" /></span>&nbsp;Easify Allegro</a></p>
        </div>
        <div class="col-sm-8 flex-item text-right">
          <ul class="top-menu">
            @if(Auth::check())
            <li><a href="{{ URL::to('/moje-szablony') }}">Moje szablony</a></li>
            <li><a href="{{ URL::to('/moje-dokumenty') }}">Moje dokumenty</a></li>
            @endif
            <li><a href="{{ URL::to('/blog') }}">Blog</a></li>
            <li><a href="{{ URL::to('/jak-dziala') }}">Jak działa</a></li>
            <li><a href="{{ URL::to('/kontakt') }}">Kontakt</a></li>
            <li>@if(Auth::check())<a href="{{ URL::to('/wyloguj') }}">Wyloguj</a>@else<a href="{{ URL::to('/zaloguj') }}">Zaloguj</a>@endif</li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  @if(Auth::check())
  <section class="user-space">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 text-left">
          @if(Auth::User()->admin == '1')
            <a href="{{ URL::to('/ea-admin') }}"><i class="fa fa-gears"></i> Administrator</a>
          @endif
        </div>
        <div class="col-sm-6 text-right">
          <a href="{{ URL::to('/ustawienia') }}"><i class="fa fa-user"></i> {{ Auth::User()->email }}</a>
        </div>
      </div>
    </div>
  </section>
  @endif
  <main>
    @yield('content')
  </main>
  <footer>
    Copyright &copy; {{date('Y')}} - <a href="http://dominiknowak.xyz">Dominik Nowak</a>
  </footer>
  <div class="cookie-info">
    <p>Potral korzysta z plików cookies. Ma to na celu lepsze świadczenie usług i dostosowanie ich do Twoich potrzeb. Korzystanie z witryny bez zmiany ustawień przeglądarki dotyczących cookies oznacza, że będą one umieszczane w Twoim urządzeniu. Więcej informacji znajdziesz w <a href="{{ URL::to('/polityka-prywatnosci') }}">Polityce prywatności</a>.</p>
    <p><a href="javascript:void(0)" id="cookie-accept" class="btn btn-custom-orange">Rozumiem</a></p>
  </div>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
  <script src="{{ URL::asset('plugins/jQuery.filer/js/jquery.filer.js') }}"></script>
  <script src="{{ URL::asset('plugins/jquery.cookie/jquery.cookie.js') }}"></script>
  <script src="{{ URL::asset('js/preloader.js') }}"></script>
  <script src="{{ URL::asset('js/main.js') }}"></script>
  <script src="{{ URL::asset('js/min-height.js') }}"></script>
  @yield('scripts')
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-70943602-1', 'auto');
    ga('send', 'pageview');
  </script>
</body>
</html>
