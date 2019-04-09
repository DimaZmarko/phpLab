<?php
header("Content-Type: text/plain; charset=utf-8");

// String #1
echo " ****String task #1**** \n";

function changeString($str)
{
    $strArray = explode('_', $str);
    $strArrayLen = count($strArray);

    $newString = '';

    for ($i = 0; $i < $strArrayLen; $i++){

        if($i > 0){

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
    foreach ( explode ( ' ', $str ) as $word ) {

        $newString .= mb_convert_encoding(strrev(mb_convert_encoding($word, 'UTF-16BE', 'UTF-8')),
                'UTF-8', 'UTF-16LE') . ' ';
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
    foreach ( $arr as $item ) {

        if ( preg_match ( '/3/', $item ) ) {

            echo $item . "\n";
        }
    }
}
$myArray = [ 342, 55, 33, 123, 66, 63, 9 ];
findItems($myArray);

echo "\n\n";


// String #4
echo " ****String task #4**** \n";

function countItems($arr)
{
    $count = 0;
    foreach ( $arr as $value ) {
        if ( preg_match_all ( '/3/', $value, $matches ) ) {
            $count += count ( $matches[0] );
        }
    }
    return $count;
}

echo countItems($myArray);

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

$map = array('A' => 'T', 'C' =>'G');

$firstTestString = 'ATTGC';
$secondTestString = 'GTAT';

echo changeChars($firstTestString, $map) . "\n";
echo changeChars($secondTestString, $map) . "\n";

echo "\n\n";
