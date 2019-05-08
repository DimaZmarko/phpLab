<?php

require_once("vendor/autoload.php");
require_once("inc/functions.php");

$loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new \Twig_Environment($loader);


$checkOrderCookies = new Twig_SimpleFunction('checkOrderCookies', function ($value) {
    if (isset($_COOKIE["price_name"]) && $_COOKIE["price_name"] === $value) {
        return "checked = 'checked'";
    }
});

$twig->addFunction($checkOrderCookies);

$checkTagCookies = new Twig_SimpleFunction('checkTagCookies', function ($value) {
    if (isset($_COOKIE["tags"]) && in_array($value, unserialize($_COOKIE["tags"]))) {
        return "checked = 'checked'";
    }
});

$twig->addFunction($checkTagCookies);

$checkCurrentPage = new Twig_SimpleFunction('checkCurrentPage', function ($value, $current) {
    if ((isset($current) && ($current == $value)) || (!isset($current) && $value === 1)) {
        return "selected";
    }
});

$twig->addFunction($checkCurrentPage);


echo $twig->render('main.html.twig', [
    'booksToDisplay' => $booksToDisplay,
    'pagesInputValue' => $pagesInputValue,
    'searchResults' => $searchResults,
    'currentPage' => $currentPage,
    'bookTags' => $bookTags,
    'pageCount' => $pageCount

]);