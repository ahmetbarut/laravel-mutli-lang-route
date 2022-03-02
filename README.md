# Laravel Multi Language Routes

It's back with a simpler use than before
Multilanguage route package similar to Symfony routes

## Setup

```bash
    composer require ahmetbarut/laravel-multi-route
```

## Features

- Annotation Available
- Multi-language

## Usage

### Simple Usage

If you want, you can specify the language to be used in the array and the index in return. This usage can inflate the route file

```php
use AhmetBarut\Multilang\Route;
use App\Http\Controllers\SomeController;


Route::get([
    '/' => 'en',
    '/tr' => 'tr',
    '/es' => 'es'
], function () {
    return 'index';
});

// OR

Route::get([
    '/' => 'en',
    '/tr' => 'tr',
    '/es' => 'es'
], [SomeController::class, 'index']);
```

## Usage With Annotations

Using it with annotations makes it look simpler and nicer, and it may be clearer to read which method supports which locales from the annotation.

> It must be used with the `@Route` directive, otherwise it will not discover routes

### example

```php

use AhmetBarut\Multilang\Route;
use App\Http\Controllers\SomeController;

/**
 * @Route('/', en)
 */
Route::get([SomeController::class ,'index']);


// SomeController.php
class SomeController extends Controller
{
    /**
     * @Route('/home', en)
     */
    public function index()
    {
        return 'index';
    }
}
```

## Usage With Array Annotations

```php

use AhmetBarut\Multilang\Route;
use App\Http\Controllers\SomeController;

/**
 * @Route([/ => en, /tr => tr, /es => es])
 */
Route::get([SomeController::class ,'index']);


// SomeController.php
class SomeController extends Controller
{
    /**
     * @Route([/ => en, /tr => tr, /es => es])
     */
    public function index()
    {
        return 'index';
    }
}
```

## Usage With Array Name

```php

use AhmetBarut\Multilang\Route;
use App\Http\Controllers\SomeController;

/**
 * @Route([/ => en, /tr => tr, /es => es])
 */
Route::get([SomeController::class ,'index'], 'some_route');


// SomeController.php
class SomeController extends Controller
{
    /**
     * @Route([/ => en, /tr => tr, /es => es])
     */
    public function index()
    {
        return 'index';
    }
}
```