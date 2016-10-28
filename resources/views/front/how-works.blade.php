@extends('layouts.master')

@section('title', 'Jak działa')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-3 relative">
      <aside class="how-works fixed">
        <ul>
          <li><a href="#wprowadzenie">Wprowadzenie</a></li>
          <li><a href="#rejestracja">Rejestracja</a></li>
          <li><a href="#logowanie">Logowanie</a></li>
          <li><a href="#przygotowanie-szablonu">Przygotowanie szablonu</a></li>
          <li><a href="#wysylanie-szablonu-na-serwer">Wysyłanie szablonu na serwer</a></li>
          <li><a href="#ustawienia-szablonu">Ustawienia szablonu</a></li>
          <li><a href="#udostepnianie-szablonu">Udostępnianie szablonu</a></li>
          <li><a href="#tworzenie-dokumentu">Tworzenie dokumentu</a></li>
          <li><a href="#wykorzystany-limit">Wykorzystany limit</a></li>
        </ul>
      </aside>
    </div>
    <div class="col-sm-9">
      <h1>Jak działa</h1>
      <h3 id="wprowadzenie">Wprowadzenie</h3>
      <p>Easify Allegro jest aplikacją internetową służącą do szybkiej podmiany treści w szablonach allegro. Wystarczy, że dobrze przygotowany szablon zostanie wysłany na serwer poprzez panel użytkownika. System samodzielnie zweryfikuje, w którym miejscu mają zostać podmienione dane i pozwoli użytkownikowi na wypełnienie go treściami przez wypełnienie pól tekstowych w panelu użytkownika.</p>

      <h3 id="rejestracja">Rejestracja</h3>
      <p>Załóż konto używając swojego adresu e-mail na stronie <a href="{{ URL::to('/rejestracja') }}">rejestracji</a>. Po poprawnym zarejestrowaniu nowego konta, otrzymasz na podany adres mailowy link aktywacyjny. Gdy już zaktywujesz konto, możesz się do niego zalogować.</p>

      <h3 id="logowanie">Logowanie</h3>
      <p>Zalogować się możesz na stronie <a href="{{ URL::to('/zaloguj') }}">logowania</a> wpisując podane dane przy rejestracji tj. adres e-mail i hasło (zwróć uwagę na wielkie litery).</p>

      <h3 id="przygotowanie-szablonu">Przygotowanie szablonu</h3>
      <p>Gdy już posiadasz konto i jesteś na nim zalogowany, nie masz żadnych szablonów. Należy najpierw utworzyć szablon. Przygotuj standardowy kod html taki jak zawsze przygotowujesz do Allegro. W miejscu gdzie mają się pojawić treści, które zmieniasz przy tworzeniu nowych aukcji, wstaw tzw. zmienne. Mogą mieć one różną postać, np.</p>
      <p><code>$$główny opis produktu$$</code></p>
      <p>Każda zmienna musi mieć swój początek i koniec. Ja dla przykładu użyłem dwóch dolarów i Tobie również polecam ich używać. Tak więc zmienna składa się początku (dwa dolary), nazwy zmiennej (główny opis produktu) i końca (dwa dolary). Nazwa zmiennej ma znaczenie w momencie tworzenia dokumentu, gdy zostanie wyświetlona jako pozycja listy, nazwij ją więc w taki sposób, abyś wiedział, w którym miejscu się ona znajduje i gdzie zostanie wstawiona treść zamiast tej zmiennej. Początek zmiennej może być różny od końca i może mieć postać:</p>
      <p><code>$$główny opis produktu##</code></p>
      <p>Trzeba pamiętać, aby nie kolidowało to z resztą kodu HTML. Koniecznie musisz unikać symboli oznaczających znaczniki HTML&nbsp;tj.&nbsp;<code>&lt;</code>&nbsp;i&nbsp;<code>&gt;</code>.</p>

      <h3 id="wysylanie-szablonu-na-serwer">Wysyłanie szablonu na serwer</h3>
      <p>Na swoim koncie w serwisie wejdź do <a href="{{ URL::to('/moje-szablony') }}">moich szablonów</a> i wybierz Nowy szablon. Zostaniesz poproszony o wybranie pliku do wysłania. Wybierz zatem plik html, który wcześniej przygotowałeś i naciśnij wyślij.</p>
      <p>Wysłany szablon zostanie zapisany pod nazwą Nowy szablon i będzie gotowy do korzystania z niego.</p>

      <h3 id="ustawienia-szablonu">Ustawienia szablonu</h3>
      <p>Wejdź do <a href="{{ URL::to('/moje-szablony') }}">moich szablonów</a> w panelu użytkownika i wybierz szablon, którym chcesz zarządzać. Pojawią się wszelkiego rodzaju opcje tj. modyfikowanie nazwy, wersji i symboli początkowych i kończących zmienne w szablonie.</p>
      <p class="alert alert-info">Uwaga: Zanim wygenerujesz dokument musisz zdefiniować początkowe i końcowe symbole zmiennych w szablonie.
      Dodatkowo jako właściciel szablonu posiadasz możliwość udostępnienia go innym. Jedynym warunkiem jest posiadanie przez nich konta w serwisie. <a href="#udostepnianie-szablonu">Więcej o udostępnianiu</a>.</p>
      <p>Za pomocą tego widoku możesz szablon usunąć, bądź go zaktualizować o nową wersję. Przy aktualizacji nie zapomnij zmienić oznaczenie wersji (nie zostanie ona zmieniona automatycznie, a pozwoli Ci na szybką weryfikację zawartości szablonu).</p>
      <p>Co najważniejsze z posiadanego szablonu możesz utworzyć właśnie dokument, z docelowymi treściami, które pojawią się na aukcji. <a href="#tworzenie-dokumentu">Więcej o tworzeniu dokumentu</a>.</p>

      <h3 id="udostepnianie-szablonu">Udostępnianie szablonu</h3>
      <p>Każdy szablon, który wysłałeś do serwisu i jesteś jego właścicielem możesz udostępnić. Udostępnianie sprawdza się w momencie, gdy jesteś Web Developerem i przygotowujesz szablony na aukcje allegro dla klientów. Możesz wówczas udostępnić klientowi szablon poprzez serwis, dzięki czemu masz cały czas kontrole nad kodem. Jeżeli zmienisz dane, zaktualizujesz, lub usuniesz szablon to te same zmiany pojawią się na koncie osoby, której udostępniłeś szablon.</p>
      <p>Osoby, którym udostępniasz szablon możesz dodać wpisując ich adres e-mail w odpowiednim polu w ustawieniach szablonu.</p>
      <p class="alert alert-info">Uwaga: Osoby, którym chcesz udostępnić szablon muszą posiadać konto zarejestrowane w serwisie.</p>
      <p>W każdym dowolnym momencie możesz usunąć udostępnioną osobę z listy i nie będzie miała ona więcej dostępu do szablonu. Nie spowoduje to jednak usunięcia dokumentów, które utworzyła w czasie, gdy była na liście.</p>

      <h3 id="tworzenie-dokumentu">Tworzenie dokumentu</h3>
      <p>Możesz zacząć tworzenie dokumentu na dwa sposoby:
        <ol>
          <li>Wybierz szablon, z którego chcesz utworzyć dokument i kliknij Utwórz dokument z tego szablonu.</li>
          <li>W moich dokumentach wybierz Nowy dokument, a następnie rozpocznij tworzenie dokumentu z wybranym szablonem.</li>
        </ol>
      </p>
      <p>Jeżeli doszedłeś do strony o nazwie Utwórz dokument to znaczy, że system wygenerował pola do wypełnienia treścią. Pola te są odniesieniem do poszczególnych zmiennych i są one nazwane tak samo jak zmienne. Dzięki takiemu rozwiązaniu masz kontrole nad tym co wpisujesz i wiesz gdzie to się znajdzie po wygenerowaniu dokumentu.</p>
      <p class="alert alert-info">Uwaga: zanim przystąpisz do wypełniania treścią, nazwij swój dokument wypełniając pierwsze pole.</p>
      <p>Przy każdym polu znajdują się pomocnicze ikony, za pomocą których:
        <ul>
          <li>Wygenerujesz listę wypunktowaną, lub numerowaną</li>
          <li>Wstawisz obrazek (tylko z adresów zewnętrznych)</li>
          <li>Wstawisz nagłówek tj. H1, H2, itd.</li>
        </ul>
      <p>Zanim wygenerujesz dokument sprawdź jak on będzie się prezentował za pomocą przycisku Podgląd na samym dole strony. Musisz jednak pamiętać, że strona została przekonwertowana do pliku pdf, co powoduje, że nie będzie dokładnym odwzorowaniem tego jak będzie się prezentowała na aukcji allegro. W związku z tym musisz dobrze przygotować stylistykę już przed wysłaniem szablonu na serwer serwisu.<p>
      <p>Jeżeli już wypełniłeś wszystkie pola i chcesz pobrać kod źródłowy to wybierz Zatwierdź.</p>
      <p class="alert alert-info">Uwaga: Funkcja Zatwierdź powoduje wygenerowanie kodu źródłowego strony i wtedy zostanie zmniejszony limit wygenerowania dokumentów.</p>
      <p>Twój kod zostanie zapisany na Twoim koncie i zawsze możesz do niego wrócić, ale bez możliwości jego poprawy.</p>

      <h3 id="wykorzystany-limit">Wykorzystany limit</h3>
      <p>Limit określa to ile możesz wygenerować dokumentów w ramach darmowego pakietu i pakietów premium. Za każdym razem, gdy wygenerujesz dokument zostaje zabrany z Twojego konta jeden punkt z limitu (punkty darmowego pakietu mają wyższy priorytet i najpierw z nich są pobierane punkty, dopiero gdy one się skończą pobierane są punkty premium).</p>
      <p>Limit darmowego pakietu jest resetowany co 30 dni począwszy od dnia zarejestrowania się użytkownika.</p>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/smooth-scrolling.js') }}"></script>
@endsection
