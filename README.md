<p align="center"><img src="public/storage/logo.png" alt="PCShelter Logo"></p>

## About PCShelter

Website for PC games lovers

## Used frameworks/libraries

laravel/sail </br>
laravel/breeze </br>
nunomaduro/larastan </br>
stechstudio/laravel-php-cs-fixer </br>
psalm/plugin-laravel </br>
itsgoingd/clockwork </br>
mailchimp/marketing </br>
spatie/laravel-permission </br>

Tailwind </br>
AlpineJS </br>
Mailhog </br>
pgSQL </br>
Mailchimp </br>

Logo : https://www.freelogodesign.org/ </br>
Fake Avatars: https://pravatar.cc/ </br>
Fake Thumbnails: https://picsum.photos/

## TODO:

<s>Zmienić wyglląd logowania/rejestracji</s> </br>
<s>Zmienić wygląd postów </s></br>
<s>Zmienić wygląd komentarzy</s> </br>
<s>Naprawić logo w postach </s></br>
<s>Dodać favicon</s> </br>
<s>Poprawić proces rejestracji - obecnie są złe pola</s> </br>
Stworzyć admina </br>
<s>Trzeba coś zrobić z ikonami postów bo na ten moment to fejki</s> </br>
<s>Posegregować componenty</s> </br>
<s>Naprawić wyświetlanie dostępnych opcji po zalogowaniu - wyświetla się @auth @endauth i są złe kolory</s> </br>
Zamienić logowanie z name na username </br>
Zmienić wygląd przycisków/opisów do kontroli numeru strony </br>
Naprawić wszystko co wykryje stan/psalm/csfixer i pamiętać by utrzymać czytsośc kodu </br>
<s>Wydzielić mniejsze komponenty z komponentów od breeze</s> </br>
Naprawić dashboard bo na ten moment nic tam nie działa / alternatywnie wymienić na coś innego </br>
<s>Narawić logowanie bo z jakiegoś powodu nie działa</s> </br>
Zmienić tak by wpisanie emaila na newsletter był potrzebny dla niezalogowanych a dla zalogowanych był pod pojedynczym przyciskiem </br>
Zmienić logikę logowania admina w AppServiceProvider bo ten obecny to mocna prowizorka </br>
<s>Naprawić wyświetlanie loga w /admin/posts/create oraz /reset/password</s> </br>
Zmienić wygląd w panelu administratora bo jest straszny </br>
<s>Naprawić edycję postów z poziomu panelu administratora bo rzuca 404 problem poega na tym, że slug to post a nie post:id</s> </br>
Najprawdopodoniej będzie trzeba rozdzielić tworzenie użytkowników na tworzenie admina/twórców/użytkowników
Przechowywać role/permisje jako stałe w pliku </br>
Stworzyć logowanie dla admina </br>
Naprawić seedowanie dla permisji </br>
Trzeba zweryfikować całe seedowanie bo straszny się tam bałagan narobił </br>
## Pomysły: </br>

Dodać opcję podejrzenia profilu po najechaniu na avatar/nazwę </br>
Ustawić dane autora na dole postu a nie pod fragmentem artykułu </br>
Dodać opcję kilku kategorii </br>
Dodać design przycisków do rejestracji logowania/konta </br>
Dodać podpowiedzi po najechaniu na przycisk (okienka z oopisem co to za przycisk) </br>
Szukanie na podstawie nazwy autora </br>
Dodać możliwość logowania przez username/email </br>
Zamienić w web.php 6 routów na Route::resource ale tak, żeby działało z post zamiast post:id </br>
