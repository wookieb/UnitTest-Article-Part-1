<?php

require_once 'autoloader.php';
set_include_path(get_include_path().PATH_SEPARATOR.'application');
$reader = new Reader('test.xml');
print_r($reader->getData());
print_r($reader->getErrors());