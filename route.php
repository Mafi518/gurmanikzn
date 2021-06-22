<?php

// print_r($_GET);

$route = key($_GET);

$_SPLIT = explode('/',$route);

// print_r($_SPLIT);

$_PAGE = $_SPLIT[0];

$fn = ($_SPLIT[0]) ? $_SPLIT[0].'.php' : 'index.php';
// $fn = ($route = key($_GET)) ? $route.'.php' : 'index.php';

if(file_exists($fn)){
	require './'.$fn;
} else {
	require '404.php';
}


?>