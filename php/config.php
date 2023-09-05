<?php
    $url = "mysql:host=localhost;dbname=trt_conseil";
    $user = 'root';
    $password = '';

    try {
        $pdo =new PDO($url, $user, $password);

        if($pdo != null) {
            
        }
    } catch (exception $e) {
        echo $e->getMessage();
    };
?>