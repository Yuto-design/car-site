<?php
    session_start();

    if (!isset($_POST['car_id'])) {
        header('Location: /');
        exit;
    }

    $car_id = $_POST['car_id'];

    if (!isset($_SESSION['compare_list'])) {
        $_SESSION['compare_list'] = [];
    }

    if (!in_array($car_id, $_SESSION['compare_list'])) {
        $_SESSION['compare_list'][] = $car_id;
    }

    header('Location: compare_list_car.php');
    exit();
?>