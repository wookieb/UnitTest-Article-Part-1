<?php

function standard_autoload($class) {
	@include_once str_replace('_', '/', $class).'.php';
}
spl_autoload_register('standard_autoload');