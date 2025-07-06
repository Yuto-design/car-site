<?php
    if (!isset($_POST['car_id'])) {
        header('Location: /');
        exit;
    }

    $car_id = $_POST['car_id'];

    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }

    if (!in_array($car_id, $_SESSION['favorites'])) {
        $_SESSION['favorites'][] = $car_id;
    }

    header('Location: /');
    exit();
?>