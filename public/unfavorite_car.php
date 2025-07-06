<?php
    session_start();

    if (!isset($_POST['car_id'])) {
        header('Location: /');
        exit;
    }

    $car_id = $_POST['car_id'];

    if (isset($_SESSION['favorites'])) {
        $index = array_search($car_id, $_SESSION['favorites']);
        if ($index !== false) {
            unset($_SESSION['favorites'][$index]);
            $_SESSION['favorites'] = array_values($_SESSION['favorites']);
        }
    }

    header('Location: /');
    exit();
?>