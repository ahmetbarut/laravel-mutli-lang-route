## Laravel Çoklu Dil Rotaları | Laravel Multi Language Routes
Symfony rotalarına benzer çoklu dil rota paketi | Multilanguage route package similar to Symfony routes
#### Kurulum | Setup
```bash 
    //
```
#### Konfigürasyon | Configuration
```config/app.php providers``` kısmına ekleyin | add to
```php 
    [
        ...
        ahmetbarut\Multilang\ahmetbarutServiceProviders::class
    ]
``` 
Sonra | Then ```php artisan vendor:publish --provider="ahmetbarut\Multilang\ahmetbarutServiceProviders"```

```app/Providers/RouteServiceProvider.php``` 
```php
    use Illuminate\Http\Request;
    
    public function map(Request $request) // Request ekleyin | add
    {
        $this->locale = $request->segment(1); // 1.
        $this->app->setlocale($this->locale); // 2.

        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }
```
```routes/web.php``` Bunları ekleyin
```php 
    use ahmetbarut\Multilang\Route as MultiLangRoute;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Route;

    $route = new MultiLangRoute(App::getLocale()); // en üste tanımladım rotalar her yenilendiğinde dil seçmesi için | I defined it at the top to choose a language every time the routes are refresh
```
Uygulamanızda dil/lokasyon değiştirme bölümünde 
```php
    use ahmetbarut\Multilang\Route as MultiLangRoute;

    public function __construct(Request $request)
    {
        $this->route = new MultiLangRoute();
    }
    >...
    public function setLang($locale)
    {
        $this->route->locale = $locale; // Önemli olan bu dil dil/lokasyon değiştirmeniz için kullanılır bu olmazsa değiştiremez 404 döndürür. | The important thing is that this language is used to change the language / location, otherwise it cannot change. It returns 404.
        return redirect($this->route->name("contact",$locale)); // Burda name() fonksiyonundaki 1. parametre rotada belirtmiş olduğum contact isminde bir rotam var. Dil/Lokasyon değiştirdiğinde o sayfaya yönlendirme yapacak. 2. parametre Dil/Lokasyon belirtiyor. Here I have a route named contact, which I specified in the 1st parameter route in the name () function. When the language / location changes, it will redirect to that page. The 2nd parameter is the Language / Location.
    }
``` 
#### Rotada Kullanım | Use on Route
```routes/web.php``` dosyasına girin. | Enter the file.
```php 
    use ahmetbarut\Multilang\Route as MultiLangRoute;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Route;

    $route = new MultiLangRoute(App::getLocale());

    Route::get(
            $route->name("contact"), // burda sadece rotaya verdiğimiz ismi yazıyoruz benim verdiğim contact. | Here we only write the name we give to the route, contact me.
            "TestController@contact")->name("contact");
```
```routes/multi_lang.php``` dosyasına gidip ordan rotaları belirtiyoruz. | We go to the file and specify the routes from there.
```php
return [
    "contact" => [
        "en" => "en/contact",
        "tr" => "tr/iletisim"
    ]
 ];
```
#### Desteklenen Lokasyonlar | Supported Locations
Desteklenen lokasyonları ```config/multi_lang.php``` dosyasından belirleyebilirsiniz. | You can specify the supported locations from the ```config/multi_lang.php`` file.
```php
return [
    "tr", "en"
];
```
#### final
