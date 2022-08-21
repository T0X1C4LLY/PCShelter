<p align="center"><img src="public/storage/public/logo.png" alt="PCShelter Logo"></p>

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
vimeo/psalm </br>

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
<s>Zmienić wygląd postów</s> </br>
<s>Zmienić wygląd komentarzy</s> </br>
<s>Naprawić logo w postach</s> </br>
<s>Dodać favicon</s> </br>
<s>Poprawić proces rejestracji - obecnie są złe pola</s> </br>
<s>Stworzyć admina</s> </br>
<s>Trzeba coś zrobić z ikonami postów bo na ten moment to fejki</s> </br>
<s>Posegregować componenty</s> </br>
<s>Naprawić wyświetlanie dostępnych opcji po zalogowaniu - wyświetla się @auth @endauth i są złe kolory</s> </br>
<s>Zamienić logowanie z email na username</s> </br>
<s>Zmienić wygląd przycisków/opisów do kontroli numeru strony</s> </br>
<s>Naprawić wszystko co wykryje stan/psalm/csfixer i pamiętać by utrzymać czytsośc kodu</s> </br>
<s>Wydzielić mniejsze komponenty z komponentów od breeze</s> </br>
<s>Naprawić dashboard bo na ten moment nic tam nie działa / alternatywnie wymienić na coś innego</s> </br>
<s>Narawić logowanie bo z jakiegoś powodu nie działa</s> </br>
<s>Zmienić tak by wpisanie emaila na newsletter był potrzebny dla niezalogowanych a dla zalogowanych był pod pojedynczym przyciskiem</s> </br>
<s>Zmienić logikę logowania admina w AppServiceProvider bo ten obecny to mocna prowizorka</s> </br>
<s>Naprawić wyświetlanie loga w /admin/posts/create oraz /reset/password</s> </br>
<s>Zmienić wygląd w panelu administratora bo jest straszny</s> </br>
<s>Naprawić edycję postów z poziomu panelu administratora bo rzuca 404 problem poega na tym, że slug to post a nie post:id</s> </br>
<s>Najprawdopodoniej będzie trzeba rozdzielić tworzenie użytkowników na tworzenie admina/twórców/użytkowników</s> </br>
<s>Przechowywać role/permisje jako stałe w pliku</s> </br>
<s>Stworzyć logowanie dla admina</s> </br>
<s>Naprawić seedowanie dla permisji</s> </br>
<s>Trzeba zweryfikować całe seedowanie bo straszny się tam bałagan narobił</s> </br>
<s>Trzeba się zastanowić czy nie da się zrobić jednej tabeli dla wszystkich użytkowników i wyznaczyć kto jaką ma role</s> </br>
<s>Przejrzeć link związany z spatie/laravel-permission (zakładka w przeglądarce) - może uda się zdecydowac czy robić 3 tabele czy rozdzielić role</s> </br>
<s>Ujednolicić wygląd całej strony bo na ten moment jest trochę zbyt duża różnorodoność</s> </br>
<s>Poprawić ponowne seedowanie gdyż obecnie trzeba skorzytać z  php artisan cache:forget spatie.permission.cache bo jest problem z istnieniem ról dla guarda "web"</s> </br>
<s>Trzeba się zastanowić jak rozegrać resetowanie hasła - obecnie można restetowac tylko po przejściu z linku</s> </br>
<s>Naprawić wygląd dodawania komentarzy</s> </br>
<s>Dodac zabezpieczenie na ilość niepoprawnych logowań</s> </br>
<s>dodać zabezpieczenie by można było zapisać się na newsletter tylko będąc zalogowanym</s> </br>
<s>Zdecydowć co z psalmem bo stwarza za dużo problemów</s> </br>
<s>Naprawić testy</s> </br>
<s>Ograniczyć ilość wyświetlanych artykułów w sekcji edycji i dodać jakąś wyszukiwarkę</s> </br>
<s>Zdecydować czy bawić się w ujednolicanie kolorystyki w formularzach w panelu administratora</s> </br>
<s>Wywalić stopkę z zakładek administratora</s> </br>
<s>Zmienić wygląd wysyłanych maili</s> </br>
<s>Zamienić pole do wpisywania email w newsletterze na informację, że jesteś już zapisany na newsletter jeśli faktycznie tak jest</s> </br>
<s>Wymuszać potwierdzenie rejestracji przed zapisem do bazy</s> </br>
<s>Dodać panel konta użytkownika</s> </br>
<s>Naprawić dodwanie postów bo nie wiadomo co się dzieje</s> </br>
<s>Zrobić kontrolery do edycji postów/danych użytkownika/komentarzy itp.</s> </br>
<s>Zrobić zwrtotkę z fail zamiast korzystać z success tam gdzie się coś nie powiodło np. UserController</s> </br>
<s>Dodać sprawdzanie bezpiecznych haseł 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'</s> </br>
Trzeba zastanowić się jak stworzyć sortowanie postów po ilości komentarzy (w przyszłości może jakiś punktów). Problem: te dane są w różnych tabelach a przesyłam obiekty </br>
Chyba będzie trzeba przenieść możliwość tworzenia artykułów do panelu użytkownika, żeby creator'zy też mogli tworzyć </br>
<s>Naprawić sekcję security bo pola zwiększają się gdy błąd jest zbyt długi - może wywalić to do failure?</s> </br>

## Pomysły: </br>

Dodać opcję podejrzenia profilu po najechaniu na avatar/nazwę </br>
Ustawić dane autora na dole postu a nie pod fragmentem artykułu </br>
Dodać opcję kilku kategorii </br>
Dodać design przycisków do rejestracji logowania/konta </br>
Dodać podpowiedzi po najechaniu na przycisk (okienka z opisem co to za przycisk) </br>
Szukanie na podstawie nazwy autora </br>
<s>Dodać możliwość logowania przez username/email</s> </br>
<s>Zamienić w web.php 6 routów na Route::resource ale tak, żeby działało z post zamiast post:id</s> </br>
<s>Może wyłączyć możliwość subskrybcji newslettera jeśli jesteśmy już zapisani?</s> </br>
<s>Dodać możliwość resetowania hasła z poziomu panelu użytkownika</s> </br>
<s>Może w sekcji admina dodać dodatkowe pola do edycji artykułów</s> </br>

## Uwagi: </br>
Pamiętać o tym, żeby ujednolicić zapis do bazy - trzymać się lowercase'ów i dbać o case sensitive </br>
Zmienne do widoków można przesyłać z kontrollerów np. return view('admin.posts.index', ['posts' => Post::paginate(50),]) </br>
