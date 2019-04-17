<?php
header("Content-Type: text/plain; charset=utf-8");

// String #1
echo " ****String task #1**** \n";

function changeString($str)
{
    $strArray = explode('_', $str);
    $strArrayLen = count($strArray);

    $newString = '';

    for ($i = 0; $i < $strArrayLen; $i++) {
        if ($i > 0) {
            $strArray[$i] = ucfirst($strArray[$i]);
        }
        $newString .= $strArray[$i];
    }

    return $newString;
}

$str = 'var_test_text';
echo changeString($str);

echo "\n\n";


// String #2
echo " ****String task #2**** \n";

function reverseString($str)
{
    $newString = '';
    for ($i = mb_strlen($str); $i >= 0; $i--) {
        $newString .= mb_substr($str, $i, 1);
    }
    return $newString;
}

echo $str1 = 'ФЫВА олдж';
echo "\n";
echo reverseString($str1);

echo "\n\n";


// String #3
echo " ****String task #3**** \n";


function findItems($arr)
{
    foreach ($arr as $item) {

        if (preg_match('/3/', $item)) {

            echo $item . "\n";
        }
    }
}

//Second Variation
function findItemsSecond($arr)
{
    foreach ($arr as $item) {
        if (strpos($item, '3') !== false) {
            echo $item . "\n";
        }
    }
}

$myArray = [342, 55, 33, 123, 66, 63, 9];

findItems($myArray);

echo "\n";

findItemsSecond($myArray);

echo "\n\n";


// String #4
echo " ****String task #4**** \n";

function countItems($arr)
{
    $count = 0;
    foreach ($arr as $value) {
        if (preg_match_all('/3/', $value, $matches)) {
            $count += count($matches[0]);
        }
    }
    return $count;
}

function countItemsSecond($arr)
{
    $toString = implode($arr);
    return mb_substr_count($toString, '3');
}

echo countItems($myArray);
echo "\n";
echo countItemsSecond($myArray);

echo "\n\n";


// BONUS TASKS
echo " ****String bonus task #1**** \n";

function bandName($str)
{
    if ($str[0] === substr($str, -1)) {
        return ucfirst($str) . substr($str, 1);
    }
    return "The " . ucfirst($str);
}

echo bandName("dolphin") . "\n";
echo bandName("alaska") . "\n";
echo bandName("europe") . "\n";

echo "\n\n";


echo " ****String bonus task #2**** \n";

/**
 * We have chars mapping: A => T, C => G.
 * You need to create a converter for strings with the results: "ATTGC" -> returns "TAACG", "GTAT" -> returns "CATA"
 **/

function changeChars($str, $map)
{
    $flipArray = array_flip($map);
    $map = array_merge($map, $flipArray);

    return strtr($str, $map);
}

$map = array('A' => 'T', 'C' => 'G');

$firstTestString = 'ATTGC';
$secondTestString = 'GTAT';

echo changeChars($firstTestString, $map) . "\n";
echo changeChars($secondTestString, $map) . "\n";

echo "\n\n";

/**
 * Завдання по рекурсії
 * написати функцію sum(x) яка по вхідному параметру буде рахувати суму всіх чисел до цього числа.
 * Наприклад sum(5) поверне 15 (1+2+3+4+5)
 */

function sum($x)
{

    if ($x === 0) {
        return 0;
    } else {
        return $x + sum($x - 1);
    }
}

echo sum(5);