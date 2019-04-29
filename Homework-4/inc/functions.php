<?php
session_start();

require_once "books.php";

$bookTags = [];
$pagesInputValue = 6;
$currentPage = 1;
$booksToDisplay = [];
$searchResults = true;

/**
 * Get all tags
 */
foreach ($books as $book) {
    if (isset($book['tags'])) {
        foreach ($book['tags'] as $tag) {
            if (in_array($tag, $bookTags)) {
                continue;
            }
            $bookTags[] = $tag;
        }
    }
}

/**
 * Books search
 */
if (isset($_SESSION["books_search"])) {
    foreach (array_keys($books) as $key) {
        foreach ($books[$key] as $field) {
            if (is_array($field)) {
                $field = implode(" ", $field);
            }

            if (stristr($field, $_SESSION["books_search"]) !== false) {
                if (!in_array($books[$key], $booksToDisplay)) {
                    $booksToDisplay[] = $books[$key];
                }
            }
        }
    }
}

$booksCount = count($booksToDisplay);
if ($booksCount <= 0) {
    $booksToDisplay = $books;
    $searchResults = false;
}

if (isset($_SESSION["books_per_page"])) {
    $pagesInputValue = $_SESSION["books_per_page"];
}

if (isset($_GET["page"])) {
    $currentPage = $_GET["page"];
}

/**
 * Order BY
 */
if (isset($_COOKIE["price_name"])) {

    $priceNameArray = [];

    foreach ($booksToDisplay as $key => $row) {
        $priceNameArray[$key] = $row[$_COOKIE["price_name"]];
    }

    array_multisort($priceNameArray, SORT_ASC, $booksToDisplay);
}

/**
 * Tags filter
 */
if (isset($_COOKIE["tags"])) {

    $bookIndexesToUnset = [];
    unserialize($_COOKIE["tags"]);

    for ($i = 0; $i < count($booksToDisplay); $i++) {
        if (!array_key_exists('tags', $booksToDisplay[$i])) {
            $bookIndexesToUnset[] = $i;
            continue;
        }

        if (count(array_intersect($booksToDisplay[$i]["tags"], unserialize($_COOKIE["tags"]))) === 0) {
            $bookIndexesToUnset[] = $i;
        }
    }

    foreach ($bookIndexesToUnset as $booksIndex) {
        unset($booksToDisplay[$booksIndex]);
    }

    $booksToDisplay = array_values($booksToDisplay);
}

$pageCount = ceil(count($booksToDisplay) / $pagesInputValue);

function checkOrderCookies($value)
{
    if (isset($_COOKIE["price_name"])) {
        if ($_COOKIE["price_name"] === $value) {
            return "checked = 'checked'";
        }
    }
}

function checkTagCookies($value)
{
    if (isset($_COOKIE["tags"])) {
        if (in_array($value, unserialize($_COOKIE["tags"]))) {
            return "checked = 'checked'";
        }
    }
}
