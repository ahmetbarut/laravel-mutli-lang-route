<?php

/**
 * @author Ahmet Barut - ahmetbarut588@gmail.com
 */
namespace ahmetbarut\Multilang;

class Route
{
    /**
     * Diziden dönen rotaları depolar | Stores the routes returned from the array
     * @var array $routes
     */
    protected static array $routes;

    /**
     * Kabul edilen diller | Accepted languages
     * @var array $acceptedLocale
     */
    protected static array $acceptedLocale;

    /**
     * Dil'i depolar | Stores the language
     * @var $locale
     */
    public $locale;


    /**
     * @param $locale
     * @return void
     */
    public function __construct($locale = null)
    {
        self::$routes = include base_path("routes/multi_lang.php");
        self::$acceptedLocale = include base_path("config/multi_lang.php");
        $this->locale = $locale;
    }

    /**
     * @param string $name
     * @param string $locale
     * @return string $routes
     */
    public function name(string $name, string $locale = null)
    {
        if (!in_array($this->locale, self::$acceptedLocale)) {
            $this->locale = "en"; // Varsayılan | Default
        }

        return self::$routes[$name][$this->locale];
    }
}
