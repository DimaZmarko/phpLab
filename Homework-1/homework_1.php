<?php
header("Content-Type: text/plain; charset=utf-8");

// Basic #1
echo " ****Task #1**** \n";

$firstPart = 'Hello';
$secondPart = 'World';
echo $firstPart . ' ' . $secondPart;

echo "\n";

//Basic #2
echo "\n ****Task #2**** \n";

$var = 'hello';
$h = substr($var, 0, 1);
$e = substr($var, 1, 1);
$o = substr($var, 4, 1);

echo $h . ' - ' . $e . ' - ' . $o;

echo "\n";


//Basic #3
echo "\n ****Task #3**** \n";
$yourVars = array(-5, 0, -3, 2);

foreach ($yourVars as $val) {
    if ($val > 0 && $val < 5) {
        echo $val . " - Вірно \n";
    } else {
        echo $val . " - Невірно \n";
    }
}


//Basic #4
echo "\n ****Task #4**** \n";

function checkDayPart($min)
{
    if ($min >= 0 && $min < 15) {
        echo 'перша';
    } elseif ($min >= 15 && $min < 30) {
        echo 'друга';
    } elseif ($min >= 30 && $min < 45) {
        echo 'третя';
    } elseif ($min >= 45 && $min < 60) {
        echo 'четверта';
    } else {
        echo 'невірний формат';
    }
}

checkDayPart(14);
echo "\n";
checkDayPart(24);
echo "\n";
checkDayPart(30);
echo "\n";
checkDayPart(55);
echo "\n";

//PHP TASK #5
echo "\n ****Task #5**** \n";

function checkYear($year)
{
    if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
        echo 'високосний рік';
    } else {
        echo 'звичайний рік';
    }
}

checkYear(2013);
echo "\n";
checkYear(2018);

//PHP TASK #6
echo "\n ****Task #6**** \n";

function lettersSum($str)
{
    $sumFirst = 0;
    $sumTwo = 0;
    $strLength = strlen($str);

    for ($i = 0; $i < $strLength; $i++) {
        if ($i < $strLength / 2) {
            $sumFirst += $str[$i];
        } else {
            $sumTwo += $str[$i];
        }
    }
    $response = ($sumFirst == $sumTwo) ? true : false;

    return $response;
}

$str = '385934';
echo lettersSum($str);

//Bonus task
echo "\n ****Bonus Task**** \n";

function equalStings($first, $second)
{

    $firstCount = 0;
    $secondCount = 0;

    $firstLen = strlen($first);
    $secondLen = strlen($second);

    if ($first === null || $first === "" || !preg_match('/^[A-Z]{1}/', $first)) {
        $firstCount += 1;
    } else {

        for ($i = 0; $i < $firstLen; $i++) {
            $firstCount += ord($first[$i]);
        }
    }

    if ($second === null || $second === "" || !preg_match('/^[A-Z]{1}/', $second)) {
        $secondCount += 1;
    } else {

        for ($j = 0; $j < $secondLen; $j++) {

            $secondCount += ord($second[$j]);
        }
    }

    $result = ($firstCount == $secondCount) ? 'equal' : 'not equal';

    return $result;

}

$st1 = "AD";
$st2 = "BC";
$st3 = "AD";
$st4 = "DD";
$st5 = null;
$st6 = "";
$st7 = "ZzZz";
$st8 = "ffPFF";

echo equalStings($st5, $st6);

