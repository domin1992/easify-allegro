# Easify Allegro
Autorska aplikacja do generowania kodu źródłowego z szablonów dla aukcji Allegro. Innymi słowy użytkownik ma możliwość wysłać kod źródłowy szablonu do aplikacji, a wtedy ona generuje pola do uzupełnienia treściami. Po uzupełnieniu tych pól, ich treści są wstawiane w odpowiednie miejsca w szablonie i wyświetla użytkownikowi gotoqy kod do wklejenia na aukcję Allegro. Aplikacja jeat aktualnie na sprzedaż jako sam mechanizm podmiany treści.

## Instalacja
1. Sklonuj projekt git
2. Za pomocą konsoli systemowej przejdź do katalogu z projektem i wpisz
	1. `composer install`
	2. `npm install`
	3. `php artisan migrate --seed`
3. Otwórz projekt w przeglądarce