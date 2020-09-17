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
     * Konfigürasyon | Configuration
     * @var array $config
     */
    protected static array $config;

    /**
     * Dil'i depolar | Stores the language
     * @var $locale
     */
    protected static $locale;


    /**
     * @param $locale
     * @return void
     */
    public static function start($locale = null)
    {
        self::$routes = include base_path("routes/multi_lang.php");
        self::$config = include base_path("config/multi_lang.php");
        self::$locale = $locale;
    }

    /**
     * @param string $name
     * @param string $locale
     * @return string $routes
     */
    public static function name(string $name, string $locale = null)
    {
        self::start("tr");
        if (!in_array(self::$locale, self::$config["accepted_language"])) {
            self::$locale = self::$config["default_language"]; // Varsayılan | Default
        }
        if($locale !== null){
            self::$locale = $locale;
        }
        return self::$routes[$name][self::$locale];
    }

    /**
     * Lokasyon/Dil Değiştirir. | Changes Location/Language.
     * @param string $locale
     * @return void
     */
    public static function setLocale($locale)
    {
        self::$locale = $locale;
    }
}
