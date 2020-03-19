<?php


$link = mysqli_connect("localhost", "root", "", "phrasegen")
or die ("Ошибка " . mysqli_connect_error());

$string = '{Пожалуйста,|Просто|Если сможете,} сделайте так, чтобы это {удивительное|крутое|простое|важное|бесполезное}' .
    ' тестовое предложение {изменялось {быстро|мгновенно|оперативно|правильно} случайным образом|менялось каждый раз}.';

function match($string)
{
    if (!preg_match_all('/{([^{}]+)}/', $string, $matches)) {
        return $string;
    }

    $arr = [];

    foreach ($matches[1] as $key => $match) {
        $searchTerm = $matches[0][$key];

        if (!array_key_exists($key, $arr)) {
            $arr[$key] = [];
        }

        $e = explode('|', $match);

        foreach ($e as $v) {
            $buffer = str_replace($searchTerm, $v, $string);

            if (strpos($buffer, "{") !== false) {
                $arr[$key][] = match($buffer);
            } else {
                $arr[$key][] = $buffer;
            }
        }
    }
    return $arr;
}

$match = match($string);
$flatten = new RecursiveIteratorIterator(new RecursiveArrayIterator($match));
$values = [];

foreach ($flatten as $v) {
      if (!in_array($v, $values)){
           $values[] = $v;
    }
}

foreach ($values as $value) {
    $insert = "INSERT INTO `phrases` (`phrase`) VALUES ('$value')";
    $result = mysqli_query($link, $insert) or die("Ошибка " . mysqli_error($link));
    echo $value."\n";
}
