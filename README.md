## Laravel Çoklu Dil Rotaları | Laravel Multi Language Routes
Symfony rotalarına benzer çoklu dil rota paketi | Multilanguage route package similar to Symfony routes
### Kurulum | Setup
```bash 
    composer require ahmetbarut/laravel-multi-route
```
### Konfigürasyon | Configuration
```config/app.php``` Dosyasına ekleyin | add to file
```php 
    'providers' => [
        ...
        ahmetbarut\Multilang\ahmetbarutServiceProviders::class,
    ]
``` 
Sonra | Then 
```bash
php artisan vendor:publish --provider="ahmetbarut\Multilang\ahmetbarutServiceProviders"
```
```php

class RouteServiceProvider extends ServiceProvider
{
    
    protected $locale; // bunu ekleyin
    ...
}
```
## Laravel 8.x
```app/Providers/RouteServiceProvider.php```
Rota ilk çalıştığında burası yüklendiğinden dolayı aşağıdai kodları ekleyiniz. | Since this is loaded when the route first runs, add the following codes.
```php
    // 1, 2, 3 ve 4 numaraları tüm satırları ekleyin.
    public function boot()
    {
        $this->configureRateLimiting();

        $this->locale = request()->segment(1); // 1.
        $this->app->setLocale($this->locale); // 2. 

        $this->routes(function () {
            Route::middleware('web')
                ->prefix($this->locale) // 3.
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->prefix($this->locale) // api kullanıyorsanız 4.
                ->namespace($this->namespace) 
                ->group(base_path('routes/api.php'));
    }
```

## Laravel 7.x 
```app/Providers/RouteServiceProvider.php```
Rota ilk çalıştığında burası yüklendiğinden dolayı aşağıdai kodları ekleyiniz. | Since this is loaded when the route first runs, add the following codes.
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
```mapWebRoutes``` Fonksiyonuna ```->prefix($this->locale)``` ekleyin. Aksi takdirde her rota tanımladığınızda lokasyon belirtmek zorunda kalırsınız. | Add ```->prefix($this->locale)``` to the ```mapWebRoutes``` Function. Otherwise, you will have to specify a location every time you define a route.
```php
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->prefix($this->locale)
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
```

```routes/web.php```
Dosyasına bunları ekleyin | Add them to the file
```php 
    use ahmetbarut\Multilang\Route as MultiLangRoute;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Route;

    new MultiLangRoute(App::getLocale()); // en üste tanımladım rotalar her yenilendiğinde dil seçmesi için | 
    // I defined it at the top to choose a language every time the routes are refresh
```
### Dil değiştirme | Change language
```php
    use ahmetbarut\Multilang\Route as MultiLangRoute;

    public function setLang($locale)
    {
        MultiLangRoute::setLocale($locale); // Önemli olan bu dil dil/lokasyon değiştirmeniz için kullanılır bu olmazsa değiştiremez 404 döndürür. | The important thing is that this language is used to change the language / location, otherwise it cannot change. It returns 404.
        return redirect(MultiLangRoute::name("contact",$locale)); // Burda name() fonksiyonundaki 1. parametre rotada belirtmiş olduğum contact isminde bir rotam var. Dil/Lokasyon değiştirdiğinde o sayfaya yönlendirme yapacak. 2. parametre Dil/Lokasyon belirtiyor. Here I have a route named contact, which I specified in the 1st parameter route in the name () function. When the language / location changes, it will redirect to that page. The 2nd parameter is the Language / Location.
    }
``` 
### Rotada Kullanım | Use on Route
```routes/web.php``` dosyasına girin. | Enter the file.
```php 
    use ahmetbarut\Multilang\Route as MultiLangRoute;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Route;

    $route = new MultiLangRoute(App::getLocale());

    Route::get(
            MultiLangRoute::name("contact"), // burda sadece rotaya verdiğimiz ismi yazıyoruz benim verdiğim contact. | Here we only write the name we give to the route, contact me.
            "TestController@contact")->name("contact");
```
### Rota Belirleme | Setting a Route 
```routes/multi_lang.php``` dosyasına gidip ordan rotaları belirtiyoruz. | We go to the file and specify the routes from there.
```php
return [
    "contact" => [
        "en" => "contact",
        "tr" => "iletisim"
    ]
 ];
```
### Desteklenen Lokasyonlar ve Varsayılan Lokasyon | Supported Locations and Default Location
Eğer uygulamanızı ziyaret eden kullanıcının kullandığı dil yoksa varsayılan lokasyonu döndürür. Desteklenen lokasyonları ```config/multi_lang.php``` dosyasından belirleyebilirsiniz. | If the user visiting your application does not have the language used, it returns the default location. You can specify the supported locations from the ```config/multi_lang.php``` file.
```php
return [
    // Desteklenen diller/lokasyonlar  | Supported languages/locations
    "accepted_language" => [
        "en","tr"
    ],
    // Varsayılan dil | default language
    "default_language" => "en",

];
```
### Rotada Parametre Gönderme | Sending Variables in Route
Parametre gönderme normal rotada olduğu gibi burdada bu şekilde kullanılır. | Parameter sending is used here as in the normal route.
```php
"set.lang" => [
    "tr" => "dil/degistir/{lang}",
    "en" => "lang/change/{lang}"
],
```
# final
