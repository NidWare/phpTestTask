<?php
    // Тест коммент
    // Объявлем какой аргумент массива какому параметру отвечает

    $method = 5;

    $file = "access_log";
    //$file = $argv[1];

    if(!file_exists($file))exit('Файла не существует');

    $file = file($file);

    $views = count($file); // Получение количества просмотров



    for ($i = 0; $i < $views; $i++) {
        $string = $file[$i];
        echo $string[0];
    //    echo hasParam($string[$method], "GET");
    }


    function hasParam($f, $s) {
        return substr_count($f, $s) > 0;
    }

?>