<?php
header("Content-Type: text/plain; charset=utf-8");

// Array #1
echo " ****Task #1**** \n";

$array = array(1, 3, 2, 4);
$newArray = array();

foreach ($array as $el) {
    for ($i = 0; $i < $el; $i++) {
        array_push($newArray, $el);
    }
}

$array = $newArray;
print_r($array);

echo "\n\n";

// Array #2
echo " ****Task #3**** \n";

$temperatures = array(
    33,
    15,
    17,
    20,
    23,
    23,
    28,
    40,
    21,
    19,
    31,
    18,
    30,
    31,
    28,
    23,
    19,
    28,
    27,
    30,
    39,
    17,
    17,
    20,
    19,
    23,
    30,
    34,
    28
);
sort($temperatures);
print_r($temperatures);

$tempLen = count($temperatures) - 1;
$median = $tempLen / 2 - 1;


echo "3 найменші значення :" . $temperatures[0] . ", " . $temperatures[1] . ", " . $temperatures[2] . "\n";
echo "3 середні значення : " . $temperatures[$median - 1] . ", " . $temperatures[$median] . ", " . $temperatures[$median + 1] . "\n";
echo "3 найбільшні значення : " . $temperatures[$tempLen - 2] . ", " . $temperatures[$tempLen - 1] . ", " . $temperatures[$tempLen];

echo "\n\n";


// Array #3
echo " ****Task #3**** \n";
$books = [
    [
        'name' => 'Learning php, mysql & JavaScript',
        'author' => 'Robin Nixon',
        'price' => 30,
        'tags' => ['php', 'javascript', 'mysql']
    ],
    [
        'name' => 'Php for the Web: Visual QuickStart Guide',
        'author' => 'Larry Ullman',
        'price' => 25,
        'tags' => ['php']
    ],
    [
        'name' => 'pHp and MySqL for Dynamic Web Sites',
        'author' => 'Larry Ullman',
        'price' => 14.39,
        'tags' => ['php', 'mysql']
    ],
    [
        'name' => 'Modern PhP: New Features and Good Practices',
        'author' => 'Josh Lockhart',
        'price' => 24,
        'tags' => ['php']
    ],
    [
        'name' => 'JavaScript and JQuery: Interactive Front-End Web Development',
        'author' => 'Jon Duckett',
        'price' => 20,
        'tags' => ['javascript', 'jquery']
    ],
    [
        'name' => 'Miss Peregrine\'s Home for Peculiar Children',
        'author' => 'Ransom Riggs',
        'price' => 8.18
    ]
];
$bookArrayLen = count($books);

foreach ($books as $key => $value) {

    $prices[$key] = $value['price'];
}

array_multisort($prices, SORT_ASC, $books);

$booksWithPhpTag = [];
foreach ($books as $book) {

    if (array_key_exists("tags", $book) && in_array("php", $book["tags"])) {
        array_push($booksWithPhpTag, $book);
    }

}
print_r($booksWithPhpTag);
echo "\n\n";


// Array BONUS TASK #2
echo " ****Bonus Task #2**** \n";

function findUnique($array)
{
    $strArray = array_map('strval', $array);
    $counted = array_count_values($strArray);
    $result = array();
    foreach ($counted as $key => $value) {
        if ($value === 1) {
            $result[] = $key;
        }
    }

    return $result;
}

print_r(findUnique(array(1, 1, 3, 5, 5)));
print_r(findUnique(array(1, 1, 3, 0.1, 0.75)));
print_r(findUnique(array(0, 0, 0.55, 0, 0)));