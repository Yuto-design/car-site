<?php
    session_start();

    if (!isset($_POST['car_id'])) {
        header('Location: compare_list_car.php');
        exit;
    }

    $car_id = $_POST['car_id'];

    if (isset($_SESSION['compare_list'])) {
        $index = array_search($car_id, $_SESSION['compare_list']);
        if ($index !== false) {
            unset($_SESSION['compare_list'][$index]);
            $_SESSION['compare_list'] = array_values($_SESSION['compare_list']);
        }
    }

    header('Location: compare_list_car.php');
    exit();
?>