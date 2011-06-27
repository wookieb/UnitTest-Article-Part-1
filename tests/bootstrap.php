<?php
// jedyny sluszny katalog roboczy
chdir(realpath(dirname(__FILE__)));

set_include_path(get_include_path().PATH_SEPARATOR.
		'../application/'.PATH_SEPARATOR. // nasza aplikacja
		'application/'.PATH_SEPARATOR. // testy naszej aplikacji
		'library/'.PATH_SEPARATOR. // dodatkowe narzędzia do testów
		'resources/fake_classes/' // klase fake
);
require_once '../autoloader.php';