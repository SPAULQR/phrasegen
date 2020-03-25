<?php

$link = mysqli_connect("localhost", "root", "", "phrasegen")
or die ("Ошибка " . mysqli_connect_error());

$string = '{Пожалуйста,|Просто|Если сможете,} сделайте так, чтобы это {удивительное|крутое|простое|важное|бесполезное}' .
    ' тестовое предложение {изменялось {быстро|мгновенно|оперативно|правильно} случайным образом|менялось каждый раз}.';

function decision($string)
{
    $arr = [];
    foreach ($string as $item) {
        preg_match('/{([^{}]+)}/u', $item, $matches);
        $temp = explode('|', $matches[1]);
        foreach ($temp as $value) {
            $arr[] = str_replace($matches[0], $value, $item);
        }
    }
    if (!(strpos($arr[count($arr) - 1], "{") === false)) {
        $arr = decision($arr);
    }
    return $arr;
}

$answer = [];
if (strpos($string, '{') === false) {
    $answer = $string;
} else {
    $input[] = $string;
    $tempArr = decision($input);
    foreach ($tempArr as $value) {
        if (!in_array($value, $answer)) {
            $answer[] = $value;
        }
    }
}

foreach ($answer as $v) {
    $insert = "INSERT INTO `phrases` (`phrase`) VALUES ('$v')";
    $result = mysqli_query($link, $insert) or die("Ошибка " . mysqli_error($link));
    echo $v . "\n";
}