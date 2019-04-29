<?php
session_start();

$booksPerPage = $_POST['books_per_page'];

$search = $_POST['search'];
$resetSearch = $_POST['reset_search'];

$filterByNamePrice = $_POST['price_name'];
$tags = $_POST['tag'];
$resetFilters = $_POST['reset_filters'];

if (isset($search) || isset($resetSearch) ||
    isset($booksPerPage) || isset($resetFilters) ||
    isset($filterByNamePrice) || isset($tags)) {

    if (isset($search)) {
        $_SESSION["books_search"] = $search;
    }

    if (isset($resetSearch)) {
        unset($_SESSION["books_search"]);
    }

    if (isset($booksPerPage)) {
        $_SESSION["books_per_page"] = $booksPerPage;
    }

    if (isset($resetFilters)) {

        if (isset($_COOKIE['price_name'])) {
            unset($_COOKIE['price_name']);
            setcookie('price_name', '', time() - 3600, '/');
        }

        if (isset($_COOKIE['tags'])) {
            unset($_COOKIE['tags']);
            setcookie('tags', '', time() - 3600, '/');
        }
    }

    if (isset($filterByNamePrice)) {
        setcookie('price_name', $filterByNamePrice, time() + 3600, '/');
    }

    if (isset($tags)) {
        setcookie('tags', serialize($tags), time() + 3600, '/');
    }

    header("Location: ../index.php");
}
