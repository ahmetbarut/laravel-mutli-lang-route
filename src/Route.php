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
    public function __construct($locale = null)
    {
        self::$routes = include base_path("routes/multi_lang.php");
        self::$config = include base_path("config/multi_lang.php");
        self::$locale = $locale;
    }

	/**
	 * Döndürülmesi istenen rotanın değerini döndürür.
	 * 	eg : home.page => /home
	 * @param string $name
	 * @param string|null $locale
	 * @return string $routes
	 */
    public static function name(string $name, string $locale = null)
    {
        if (accepted_locale(self::$locale)) {
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
