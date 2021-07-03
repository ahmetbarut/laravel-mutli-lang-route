<?php

if (!function_exists("accepted_locale")) {
	/**
	 * Yerelin varlığını kontrol eder
	 * @param string $locale yerel adı
	 * @return bool
	 */
    function accepted_locale(string $locale): bool
	{
		$locales = include base_path("config/multi_lang.php");

		return in_array($locale, $locales);
	}
}