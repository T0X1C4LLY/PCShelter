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
brianium/paratest </br>
propaganistas/laravel-disposable-email </br>
invisnik/laravel-steam-auth </br>

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
<s>Trzeba zastanowić się jak stworzyć sortowanie postów po ilości komentarzy (w przyszłości może jakiś punktów). Problem: te dane są w różnych tabelach a przesyłam obiekty - może łaczyć te dane w kontrolerach i wysyłać jako stdObject albo uj wie co innnego</s> </br>
<s>Chyba będzie trzeba przenieść możliwość tworzenia artykułów do panelu użytkownika, żeby creator'zy też mogli tworzyć</s> </br>
<s>Naprawić sekcję security bo pola zwiększają się gdy błąd jest zbyt długi - może wywalić to do failure?</s> </br>
<s>Dodać możliwość aktualizacji roli użytkownika w sekcji admina</s> </br>
Trzeba się zastanowić jakie dane o użytkowniku powinienem móc widzieć w panelu administratora </br>
<s>Dodać ustawianie roli dla użytkownika przy tworzeniu konta</s> </br>
<s>Przy wyszukiwaniu trzeba zadabać o case sensitive</s> </br>
<s>Zamienić zapytania do bazki wewnątrz blade'ów na relacje (model relationships)</s> </br>
<s>Zamienić gate'y tak by opierały się na permisjach a nie na rolach</s> </br>
<s>Zamienić tego if'a z newslettera na permisję</s> </br>
<s>Stworzyć opcję usunięcia subskrypcji newslettera</s> </br>
<s>Zrobić wstrzykiwanie Mailchimpa z domyślnymi ustawieniami</s> </br>
<s>Usunąć stopkę z newsletterem w panelu admina/użytkownika</s> </br>
<s>Napisać testy na dosłownie wszystko</s> </br>
<s>Napisać testy na komponenty</s> </br>
<s>Wyłączyć zapisywanie obrazów w storage przy testach - AllPostsTest test_post_can_be_edited()</s> </br>
<s>Może wrzucić testy do jednego pliku tak, żeby nie robić miliona razy factory()->create()</s> </br>
<s>Trzeba zająć się routami bo się bałagan zrobił co gdzie powinno walić</s> </br>
<s>Stworzyć dummy implementation dla newslettera dla testów</s> </br>
<s>Skorzystać z zabezpieczenia przy dodawaniu komentarzy</s> </br>
<s>Trzeba stworzyć factory dla roles/permission żeby id było z uuid albo robić to w seederach</s> </br>
<s>Seedować Review (sprawdzić czy 1 użytkownik może dać 1 opinię na temat danej gry)</s> </br>
<s>Połączyć sprawdzanie czy posiadam daną grę z dodawaniem recenzji</s> </br>
<s>Dodać wyszukiwarkę gier - po nazwie z bazy i po steamid - dodawać grę do bazy jeśli jeszcze jej tam nie ma</s> </br>
<s>Ujednolicić wygląd postów (stopka na samym dole artykuły a nie bezpośrednio pod fragmentem tekstu)</s> </br>
<s>Naprawić wyświetlanie avatarów (wysyłany jest UUID i sobie nie radzi)</s> </br>
<s>Naprawić wyświetlanie przycisku Read More (potrafi wyświetlać się w 2 częściach)</s> </br>
<s>Stworzyć przejście między blogiem a sekcją gier</s> </br>
<s>Stworzyć wyszukiwarkę spersonalizowanych gier</s> </br>
<s>Dodać do bazki kategorii i gatunków</s> </br>
<s>Dodać Seedowanie do kategorii i gatunków</s> </br>
<s>Dodać dopisywanie nowych kategorii i gatunków tak jak robię to z grami</s> </br>
<s>Dodać dopisywanie danych do json'a z grami za każdym razem jak jakieś trafi do bazki</s> </br>
<s>Poprawić wyszukiwarkę gier</s> </br>
Strona nie ładuje się gdy nie ma postów - naprawić </br>
<s>Dodać datę wydania gry do bazy/pliku</s> </br>
<s>Dołożyć walidację formularza do wyszukiwarki gier</s> </br>
<s>Dołożyć znaczniki od/do na dacie w wyszukiwarce gier</s> </br>
<s>W GameFinderController i Game mam takie same tablice, może wyodrębnić do Enuma lub env</s> </br>
Zamienić latające obiekty na arraye </br>
Pokryć kod testami </br>
Zaktualizować libki </br>
Naprawić błędy larastana / spróbować psalmu </br>
Wyodrębnić logikę do prywatnych metod / zastanowić się gdzie możnaby ją przenieść </br>
Sprawdzić i ewentualnie przepisać SQL na raw jeśli te będą działąć szybciej </br>
Możliwie pozbyć się logiki z widoków </br>
Wyodrębnić logikę z kontrolerów do serwisów </br>
Naprawiać klasa po klasie: </br>
    <s>app/Console/Kernel.php </br>
    app/Enums/AdminPostsOrderByTypes.php </br>
    app/Enums/AdminUsersOrderByTypes.php </br>
    app/Enums/ReviewCategory.php </br>
    app/Enums/SortOrder.php </br>
    app/Exceptions/Handler.php </br>
    app/Exceptions/InvalidDataRangeException.php </br>
    app/Exceptions/InvalidOrderArgumentException.php </br>
    app/Exceptions/InvalidPaginationInfoException.php </br>
    app/Exceptions/SteamResponseException.php </br>
    app/Facades/ArrayPagination.php </br>
    app/Http/Controllers/Auth/AuthenticatedSessionController.php </br>
    app/Http/Controllers/Auth/ConfirmablePasswordController.php </br>
    app/Http/Controllers/Auth/EmailVerificationNotificationController.php </br>
    app/Http/Controllers/Auth/EmailVerificationPromptController.php </br>
    app/Http/Controllers/Auth/NewPasswordController.php </br>
    app/Http/Controllers/Auth/PasswordResetLinkController.php </br>
    app/Http/Controllers/Auth/RegisteredUserController.php </br>
    app/Http/Controllers/Auth/VerifyEmailController.php </br>
    app/Http/Controllers/AdminPostController.php </br>
    app/Http/Controllers/AdminUserController.php </br>
    app/Http/Controllers/Controller.php </br>
    app/Http/Controllers/GameController.php </br>
    app/Http/Controllers/GameFinderController.php </br>
    app/Http/Controllers/NewsletterController.php </br>
    app/Http/Controllers/PostCommentsController.php </br>
    app/Http/Controllers/PostController.php </br>
    app/Http/Controllers/ReviewController.php </br>
    app/Http/Controllers/SteamAuthController.php </br>
    app/Http/Controllers/UserController.php </br>
    app/Http/Controllers/UsersCommentsController.php </br>
    app/Http/Controllers/UsersPostsController.php </br>
    app/Http/Controllers/UserSteamController.php </br>
    app/Http/Middleware/Authenticate.php </br>
    app/Http/Middleware/EncryptCookies.php </br>
    app/Http/Middleware/OwnTheGame.php </br>
    app/Http/Middleware/PreventRequestsDuringMaintenance.php </br>
    app/Http/Middleware/RedirectIfAuthenticated.php </br>
    app/Http/Middleware/TrimStrings.php </br>
    app/Http/Middleware/TrustHosts.php </br>
    app/Http/Middleware/TrustProxies.php </br>
    app/Http/Middleware/VerifyCsrfToken.php </br>
    app/Http/Requests/Auth/LoginRequest.php </br>
    app/Http/Kernel.php </br>
    app/Models/Category.php </br>
    app/Models/Comment.php </br>
    app/Models/Game.php </br>
    app/Models/GameCategory.php </br>
    app/Models/Genre.php </br>
    app/Models/Post.php </br>
    app/Models/Review.php </br>
    app/Models/User.php </br>
    app/Other/ArrayPagination.php </br>
    app/Other/SteamInfo.php </br>
    app/Providers/AppServiceProvider.php </br>
    app/Providers/AuthServiceProvider.php </br>
    app/Providers/BroadcastServiceProvider.php </br>
    app/Providers/EventServiceProvider.php </br>
    app/Providers/RouteServiceProvider.php </br>
    app/Rules/GreaterOrEqualIfExists.php </br>
    app/Services/Interfaces/Creator.php </br>
    app/Services/Interfaces/HTMLBuilder.php </br>
    app/Services/Interfaces/ModelPaginator.php </br>
    app/Services/Interfaces/Newsletter.php </br>
    app/Services/Interfaces/Search.php </br>
    app/Services/Creator.php </br>
    app/Services/HTMLBuilder.php </br>
    app/Services/MailchimpNewsletter.php </br>
    app/Services/ModelPaginator.php </br>
    app/Services/GameFinder.php </br>
    app/Services/HTMLBuilder.php </br>
    app/Services/MailchimpNewsletter.php </br>
    app/Services/ModelPaginator.php </br>
    app/Steam/Library.php </br>
    app/Steam/MyGame.php </br>
    app/Traits/EnumValuesTrait.php </br>
    app/Traits/TraitUuid.php </br>
    app/ValueObjects/AdminPostsOrderBy.php </br>
    app/ValueObjects/AdminUsersOrderBy.php </br>
    app/ValueObjects/DateRange.php </br>
    app/ValueObjects/FinderParams.php </br>
    app/ValueObjects/Page.php </br>
    app/ValueObjects/PaginationInfo.php </br>
    app/View/Components/AppLayout.php </br>
    app/View/Components/GuestLayout.php </br>
    database/factories/CategoryFactory.php </br>
    database/factories/CommentFactory.php </br>
    database/factories/PostFactory.php </br>
    database/factories/UserFactory.php </br>
    database/seeders/CategoriesSeeder.php </br>
    database/seeders/CommentsSeeder.php </br>
    database/seeders/DatabaseSeeder.php </br>
    database/seeders/GameCategoriesSeeder.php </br>
    database/seeders/GamesSeeder.php </br>
    database/seeders/GenresSeeder.php </br>
    database/seeders/PermissionsAndRolesSeeder.php </br>
    database/seeders/PostsSeeder.php </br>
    database/seeders/ReviewsSeeder.php </br>
    database/seeders/UsersSeeder.php </br></s>
<s>Dorzucić trochę gier do pliku seedującego i pozbyć się logiki dopisywania do pliku gier/kategorii/gatunków </s></br>
users/index.blade chyba powinien mieć użyte post-anchor.blade </br>
Skorzystać z composer require https://github.com/beyondcode/laravel-credentials i wrzucić tam API Key</br>
Przejść na uuid gdzie się da </br>
Skorzystać z Dusk dla lepszych testów </br>
<s>Naprawić wyszukiwanie postów - nie da się filtrować po autorze kategorii i search jednocześnie </s></br>
<s>Odebrać możliwość dodawania kilku recenzji przez tego samego użytkownika </s></br>
Dodać logikę niedodawania recenzji do gier które jeszcze nie wyszły </br>
Usunąć dane ze steam w UsersSeeder </br>

## Pomysły: </br>

Dodać opcję podejrzenia profilu po najechaniu na avatar/nazwę </br>
<s>Ustawić dane autora na dole postu a nie pod fragmentem artykułu</s> </br>
Dodać opcję kilku kategorii </br>
Dodać design przycisków do rejestracji logowania/konta </br>
Dodać podpowiedzi po najechaniu na przycisk (okienka z opisem co to za przycisk) </br>
Szukanie na podstawie nazwy autora </br>
<s>Dodać możliwość logowania przez username/email</s> </br>
<s>Zamienić w web.php 6 routów na Route::resource ale tak, żeby działało z post zamiast post:id</s> </br>
<s>Może wyłączyć możliwość subskrybcji newslettera jeśli jesteśmy już zapisani?</s> </br>
<s>Dodać możliwość resetowania hasła z poziomu panelu użytkownika</s> </br>
<s>Może w sekcji admina dodać dodatkowe pola do edycji artykułów</s> </br>
Dawać ostrzeżenie administratorowi przed usunięciem postu/użytkownika? </br>

## Uwagi: </br>
Pamiętać o tym, żeby ujednolicić zapis do bazy - trzymać się lowercase'ów i dbać o case sensitive </br>
Zmienne do widoków można przesyłać z kontrollerów np. return view('admin.posts.index', ['posts' => Post::paginate(50),]) </br>
index, show, create, store, edit, update, destroy  - 7 restful actions </br>
protected $guarded = ['id']; //wszytsko jest fillable oprócz id </br>
protected $fillable = ['title', 'excerpt', 'body']; // pozwala tworzyć nowe obiekty z poziomu tinkera w następujący sposób: php artisan tinker     Post::create(['title' => 'cos', 'excerpt' => 'cos]) </br>
protected $with = ['category', 'author']; //to pozwoli za każdym razem wczytać te 2 dane przy zapytaniach SQl - przydatne bo rozwiazuje problem n+1 ale nie zawsze musimy chcieć te dane pobrać także używać z rozsądkiem - alternatywa jest w web.php 'posts' => $author->posts->load(['category', 'author']) </br>
public function getRouteKeyName(): string {return 'slug';} //to jest potrzebne, żeby znaleźć rekord z bazy po slug-u gdy w Route mamy {post} a nie {post:slug} </br>
public function comments(): HasMany{ return $this->hasMany(Comment::class);} // Laravel zakłada, że klucz obcy będzie nazywał się user_id - nazwaMetody_id </br>
public function getCreatedAtAttribute(string $created_at): Carbon //Accessor </br>
public function setPasswordAttribute(string $password): void //Mutator: set + nazwa_atrybutu + Attribute() </br>
